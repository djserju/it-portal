<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaffRequest;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class StaffController extends Controller
{
    public function index(): View
    {
        return view('admin.staff.index', [
            'staffMembers' => Staff::orderBy('name')->get(),
        ]);
    }

    public function store(StoreStaffRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $photoPath = $request->file('photo')->store('staff', 'public');

        if ($photoPath === false) {
            throw new RuntimeException('The staff photo could not be saved.');
        }

        $disk = Storage::disk('public');

        try {
            Staff::create([
                'name' => $validated['name'],
                'position' => $validated['position'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'photo' => $photoPath,
            ]);
        } catch (Throwable $exception) {
            if ($disk->exists($photoPath) && ! $disk->delete($photoPath)) {
                throw new RuntimeException('The staff photo could not be removed after saving the staff record failed.', previous: $exception);
            }

            throw $exception;
        }

        return to_route('admin.staff.index')->with('status', 'Staff member added.');
    }

    public function destroy(Staff $staff): RedirectResponse
    {
        $photoPath = $staff->photo;
        $staff->delete();

        $disk = Storage::disk('public');

        if ($disk->exists($photoPath) && ! $disk->delete($photoPath)) {
            throw new RuntimeException('The staff member was deleted, but their photo could not be removed.');
        }

        return to_route('admin.staff.index')->with('status', 'Staff member deleted.');
    }
}

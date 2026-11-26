<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveCourseRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('admin.courses.index', [
            'courses' => Course::orderBy('code')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.courses.form');
    }

    public function store(SaveCourseRequest $request): RedirectResponse
    {
        Course::create($request->validated());

        return to_route('admin.courses.index')->with('status', 'Course added.');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.form', compact('course'));
    }

    public function update(SaveCourseRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        return to_route('admin.courses.index')->with('status', 'Course updated.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return to_route('admin.courses.index')->with('status', 'Course deleted.');
    }
}

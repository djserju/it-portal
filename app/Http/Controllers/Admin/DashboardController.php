<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Message;
use App\Models\Staff;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'courseCount' => Course::count(),
            'staffCount' => Staff::count(),
            'messageCount' => Message::count(),
        ]);
    }
}

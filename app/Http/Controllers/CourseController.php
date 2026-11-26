<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Contracts\View\View;

class CourseController extends Controller
{
    public function show(Course $course): View
    {
        return view('pages.course', compact('course'));
    }
}

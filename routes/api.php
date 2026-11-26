<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/courses', function () {
    return Course::orderBy('code')->get();
});

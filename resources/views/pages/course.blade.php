@extends('layouts.portal')

@section('title', $course->code . ' — ' . $course->name . ' | UCC')

@section('content')
    <section class="page-hero">
        <div class="container">
            <a class="back-link" href="{{ route('courses.index') }}">&larr; Back to all courses</a>
            <p class="eyebrow">{{ $course->code }} · {{ $course->credits }} credits</p>
            <h1>{{ $course->name }}</h1>
            <p>Course information from the Department of Information Technology catalog.</p>
        </div>
    </section>

    <section class="container course-detail-layout section-block">
        <article class="course-detail-card">
            <p class="eyebrow">About this course</p>
            <h2>Course description</h2>
            <p class="course-detail-description">{{ $course->description }}</p>

            <div class="course-detail-facts">
                <div>
                    <span>Course code</span>
                    <strong>{{ $course->code }}</strong>
                </div>
                <div>
                    <span>Credits</span>
                    <strong>{{ $course->credits }}</strong>
                </div>
                <div>
                    <span>Prerequisite</span>
                    <strong>{{ $course->prerequisites ?: 'None' }}</strong>
                </div>
            </div>
        </article>

        <aside class="course-detail-aside">
            <p class="eyebrow">Plan your studies</p>
            <h2>Questions about this course?</h2>
            <p>Contact the Head of Department for help with course information and academic inquiries.</p>
            <a class="button button-primary button-full" href="{{ route('contact') }}">Contact the HOD <span aria-hidden="true">&rarr;</span></a>
        </aside>
    </section>
@endsection

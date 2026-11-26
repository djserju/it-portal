@extends('layouts.portal')

@section('title', 'IT Courses | UCC')

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">Plan your learning</p>
            <h1>Information Technology courses</h1>
            <p>Explore course topics, credit values, and prerequisites to plan your studies.</p>
        </div>
    </section>

    <section class="container section-block" aria-label="Course catalog">
        <div class="catalog-meta">
            <p>{{ $courses->count() }} courses in the catalog</p>
            <a class="text-link" href="{{ route('admissions') }}">Considering UCC? View admissions <span aria-hidden="true">&rarr;</span></a>
        </div>
        @if ($courses->isEmpty())
            <div class="empty-state">
                <h2>Courses will be listed here soon</h2>
                <p>Please check back later or contact the department for details.</p>
            </div>
        @else
            <div class="course-grid">
                @foreach ($courses as $course)
                    <a class="course-card" href="{{ route('courses.show', ['course' => $course->code]) }}" aria-label="View details for {{ $course->code }}: {{ $course->name }}">
                        <div class="course-card-meta">
                            <span class="course-code">{{ $course->code }}</span>
                            <span class="credit-count">{{ $course->credits }} credits</span>
                        </div>
                        <h2>{{ $course->name }}</h2>
                        <p>{{ $course->description }}</p>
                        <div class="course-prerequisite">
                            <span>Prerequisite</span>
                            <strong>{{ $course->prerequisites ?: 'None' }}</strong>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection

@extends('layouts.portal')

@section('title', 'Department of Information Technology | UCC')

@section('content')
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow">University of the Commonwealth Caribbean</p>
                <h1>Build the skills to shape <span>what comes next.</span></h1>
                <p class="hero-description">Explore technology, learn from experienced faculty, and prepare for the opportunities of a connected world.</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('courses.index') }}">Explore courses <span aria-hidden="true">&rarr;</span></a>
                    <a class="button button-outline" href="{{ route('admissions') }}">Admissions information</a>
                </div>
            </div>
            <aside class="hero-panel" aria-label="Department at a glance">
                <div class="hero-panel-top">
                    <span class="hero-icon" aria-hidden="true">IT</span>
                    <span class="panel-label">Department at a glance</span>
                </div>
                <p class="hero-panel-title">Technology is more than code. It is how we solve problems and move ideas forward.</p>
                <div class="hero-stats">
                    <div><strong>{{ $courseCount }}</strong><span>IT courses</span></div>
                    <div><strong>{{ $staffCount }}</strong><span>Faculty &amp; staff</span></div>
                </div>
            </aside>
        </div>
    </section>

    <section class="container section-block" aria-labelledby="explore-heading">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Your next step starts here</p>
                <h2 id="explore-heading">Explore the department</h2>
            </div>
            <p>Find the information and people you need, all in one place.</p>
        </div>

        <div class="feature-grid">
            <a class="feature-card" href="{{ route('staff.index') }}">
                <span class="feature-number">01</span>
                <h3>Faculty &amp; staff</h3>
                <p>Meet the team supporting your learning and academic journey.</p>
                <span class="feature-link">Browse the directory <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="feature-card" href="{{ route('courses.index') }}">
                <span class="feature-number">02</span>
                <h3>Course catalog</h3>
                <p>Review course descriptions, credit values, and prerequisites.</p>
                <span class="feature-link">View courses <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="feature-card" href="{{ route('admissions') }}">
                <span class="feature-number">03</span>
                <h3>Admissions</h3>
                <p>Learn about undergraduate entry requirements and applying to UCC.</p>
                <span class="feature-link">See requirements <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="feature-card" href="{{ route('contact') }}">
                <span class="feature-number">04</span>
                <h3>Contact the HOD</h3>
                <p>Send a question or request information from the department.</p>
                <span class="feature-link">Get in touch <span aria-hidden="true">&rarr;</span></span>
            </a>
            <a class="feature-card" href="{{ route('social') }}">
                <span class="feature-number">05</span>
                <h3>Social media</h3>
                <p>Catch UCC updates on Facebook, X, and Instagram.</p>
                <span class="feature-link">View social feeds <span aria-hidden="true">&rarr;</span></span>
            </a>
        </div>
    </section>

    <section class="contact-banner">
        <div class="container contact-banner-inner">
            <div>
                <p class="eyebrow">Have a question?</p>
                <h2>We’re here to help you find your way.</h2>
            </div>
            <a class="button button-light" href="{{ route('contact') }}">Contact the department <span aria-hidden="true">&rarr;</span></a>
        </div>
    </section>
@endsection

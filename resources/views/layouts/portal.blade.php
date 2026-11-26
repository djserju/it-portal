<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Explore Information Technology courses, faculty, and admissions at the University of the Commonwealth Caribbean.')">
    <title>@yield('title', 'Department of Information Technology | UCC')</title>
    @PwaHead
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
    @stack('head')
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>

    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark" aria-hidden="true">UCC</span>
                <span class="brand-copy">
                    <strong>Department of Information Technology</strong>
                    <span>University of the Commonwealth Caribbean</span>
                </span>
            </a>
            @guest
                <a class="staff-login" href="{{ route('login') }}">Staff login</a>
            @else
                <a class="staff-login" href="{{ route('dashboard') }}">Staff dashboard</a>
            @endguest
        </div>
    </header>

    <nav class="site-nav" aria-label="Main navigation">
        <div class="container nav-container">
            <input class="nav-toggle-checkbox" id="site-menu-toggle" type="checkbox">
            <label class="nav-toggle" for="site-menu-toggle">
                <span>Explore the department</span>
                <svg aria-hidden="true" viewBox="0 0 20 20" fill="none">
                    <path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </label>
            <div class="nav-links">
                <a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')]) @if (request()->routeIs('home')) aria-current="page" @endif>Home</a>
                <a href="{{ route('courses.index') }}" @class(['is-active' => request()->routeIs('courses.*')]) @if (request()->routeIs('courses.*')) aria-current="page" @endif>Courses</a>
                <a href="{{ route('staff.index') }}" @class(['is-active' => request()->routeIs('staff.*')]) @if (request()->routeIs('staff.*')) aria-current="page" @endif>Faculty &amp; Staff</a>
                <a href="{{ route('admissions') }}" @class(['is-active' => request()->routeIs('admissions')]) @if (request()->routeIs('admissions')) aria-current="page" @endif>Admissions</a>
                <a href="{{ route('contact') }}" @class(['is-active' => request()->routeIs('contact*')]) @if (request()->routeIs('contact*')) aria-current="page" @endif>Contact the HOD</a>
                <a href="{{ route('social') }}" @class(['is-active' => request()->routeIs('social')]) @if (request()->routeIs('social')) aria-current="page" @endif>Social media</a>
            </div>
        </div>
    </nav>

    <main id="main-content" class="site-main">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div class="footer-about">
                <a class="footer-brand" href="{{ route('home') }}">UCC <span>Information Technology</span></a>
                <p>Department of Information Technology<br>University of the Commonwealth Caribbean</p>
            </div>
            <div class="footer-navigation">
                <h2>Explore</h2>
                <a href="{{ route('courses.index') }}">Course catalog</a>
                <a href="{{ route('staff.index') }}">Faculty &amp; staff</a>
                <a href="{{ route('admissions') }}">Admissions</a>
                <a href="{{ route('contact') }}">Contact the HOD</a>
            </div>
            <div class="footer-social">
                <h2>Social media</h2>
                <p>Follow UCC for university news and updates.</p>
                <a class="footer-social-page-link" href="{{ route('social') }}">View social feeds <span aria-hidden="true">&rarr;</span></a>
                <div class="social-links">
                    @foreach (config('portal.social_links') as $socialLink)
                        <a href="{{ $socialLink['url'] }}" target="_blank" rel="noopener noreferrer">{{ $socialLink['name'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; {{ date('Y') }} University of the Commonwealth Caribbean</p>
            </div>
        </div>
    </footer>

    <x-email-fab />
    @RegisterServiceWorkerScript
</body>
</html>

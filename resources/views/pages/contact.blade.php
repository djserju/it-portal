@extends('layouts.portal')

@section('title', 'Contact the HOD | UCC')

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">We’re glad you reached out</p>
            <h1>Contact the Head of Department</h1>
            <p>Send an inquiry to the Department of Information Technology. We’ll be in touch as soon as possible.</p>
        </div>
    </section>

    <section class="container contact-layout section-block">
        <aside class="contact-card">
            <p class="eyebrow">Department contact</p>
            <h2>{{ $hod->name ?? 'Head of Department (IT)' }}</h2>
            <p class="contact-role">{{ $hod->position ?? 'Department of Information Technology' }}</p>
            <div class="contact-detail">
                <span>Email</span>
                <a href="mailto:{{ config('portal.hod_email') }}">{{ config('portal.hod_email') }}</a>
            </div>
            @if ($hod)
                <div class="contact-detail">
                    <span>Phone</span>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hod->phone) }}">{{ $hod->phone }}</a>
                </div>
            @endif
            <p class="contact-note">Prefer email? Use the floating email button on this page to open a message to the HOD.</p>
        </aside>

        <div class="contact-form-card">
            <h2>Send a message</h2>
            <p class="form-intro">Complete the form below and your message will be sent to the department.</p>

            @if (session('status'))
                <div class="form-success" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" class="contact-form">
                @csrf
                <div class="form-field">
                    <label for="name">Your name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="100" required aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="120" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                    @error('email')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="subject">Subject</label>
                    <input id="subject" name="subject" type="text" value="{{ old('subject') }}" maxlength="150" required aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}">
                    @error('subject')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <div class="form-field">
                    <label for="message">How can we help?</label>
                    <textarea id="message" name="message" rows="6" minlength="10" maxlength="1000" required aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}">{{ old('message') }}</textarea>
                    <span class="field-hint">Please enter between 10 and 1,000 characters.</span>
                    @error('message')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                <button class="button button-primary" type="submit">Send message <span aria-hidden="true">&rarr;</span></button>
            </form>
        </div>
    </section>
@endsection

@extends('layouts.portal')

@section('title', 'Faculty & Staff Directory | UCC')

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">People behind the program</p>
            <h1>Faculty &amp; staff directory</h1>
            <p>Connect with the faculty and staff of the Department of Information Technology.</p>
        </div>
    </section>

    <section class="container section-block" aria-label="Faculty and staff">
        @if ($staffMembers->isEmpty())
            <div class="empty-state">
                <h2>The directory is being updated</h2>
                <p>Please contact the department if you need assistance.</p>
            </div>
        @else
            <div class="staff-grid">
                @foreach ($staffMembers as $person)
                    <article class="staff-card">
                        <img
                            class="staff-photo"
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($person->photo) }}"
                            alt=""
                            width="96"
                            height="96"
                            loading="lazy"
                        >
                        <div class="staff-details">
                            <p class="staff-role">{{ $person->position }}</p>
                            <h2>{{ $person->name }}</h2>
                            <a class="staff-contact" href="mailto:{{ $person->email }}">{{ $person->email }}</a>
                            <a class="staff-contact" href="tel:{{ preg_replace('/[^0-9+]/', '', $person->phone) }}">{{ $person->phone }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection

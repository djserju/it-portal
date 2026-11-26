@extends('layouts.portal')

@section('title', 'Admissions | UCC Information Technology')

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">Start your UCC journey</p>
            <h1>Undergraduate admissions</h1>
            <p>Review the general entry requirements and find the next step toward your program.</p>
        </div>
    </section>

    <section class="container admissions-layout section-block">
        <div class="admissions-main">
            <p class="eyebrow">Jamaican applicants</p>
            <h2>Undergraduate entry requirements</h2>
            <p>UCC's published requirements for Jamaican applicants to undergraduate programmes include:</p>

            <div class="requirement-list">
                <article class="requirement-card">
                    <span class="requirement-number">01</span>
                    <div>
                        <h3>Five qualifying subjects</h3>
                        <p>Five GCE or CSEC subjects, including English Language and Mathematics, at grades A, B or C (GCE) or 1, 2 or 3 (CSEC). CSEC grade 3 results must be from 1998 onward.</p>
                    </div>
                </article>
                <article class="requirement-card">
                    <span class="requirement-number">02</span>
                    <div>
                        <h3>Applicants completing subjects</h3>
                        <p>Applicants with four CSEC subjects may apply while completing outstanding subjects or UCC replacement courses in Core Mathematics, English for Academic Purposes, and Fundamentals of Accounting.</p>
                    </div>
                </article>
                <article class="requirement-card">
                    <span class="requirement-number">03</span>
                    <div>
                        <h3>Mature-entry applicants</h3>
                        <p>Applicants must be at least 25 years old and have at least five years of work experience. UCC requests academic qualifications, a resume, a job letter, and three professional references.</p>
                    </div>
                </article>
            </div>

            <p class="admissions-note">Requirements may vary by programme. Check UCC's official site for the latest details and application guidance.</p>
        </div>

        <aside class="apply-card">
            <p class="eyebrow">Ready to begin?</p>
            <h2>Take the next step</h2>
            <p>Visit UCC for current admissions information and the undergraduate application.</p>
            <a class="button button-primary button-full" href="https://ucc.edu.jm/programmes/undergraduate/requirements" target="_blank" rel="noopener noreferrer">Official requirements <span aria-hidden="true">&nearr;</span></a>
            <a class="button button-outline button-full" href="https://ucc.edu.jm/apply/undergraduate" target="_blank" rel="noopener noreferrer">Apply to UCC <span aria-hidden="true">&nearr;</span></a>
            <p class="apply-help">Questions about IT courses? <a href="{{ route('contact') }}">Contact the HOD</a>.</p>
        </aside>
    </section>
@endsection

@extends('layouts.portal')

@section('title', 'UCC on Social Media | UCC')

@section('content')
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">Connect with UCC</p>
            <h1>UCC on social media</h1>
            <p>Catch up with UCC updates through the platforms' official feeds and profile pages.</p>
        </div>
    </section>

    <section class="container section-block" aria-label="UCC social media feeds">
        <div class="social-feed-grid">
            <article class="social-feed-card social-feed-card-facebook">
                <header class="social-feed-header">
                    <div>
                        <p class="eyebrow">Facebook</p>
                        <h2>UCC Jamaica</h2>
                    </div>
                    <a href="https://www.facebook.com/uccjamaica" target="_blank" rel="noopener noreferrer">Open profile <span aria-hidden="true">&nearr;</span></a>
                </header>
                <iframe
                    class="facebook-feed"
                    src="https://www.facebook.com/plugins/page.php?href={{ urlencode('https://www.facebook.com/uccjamaica') }}&amp;tabs=timeline&amp;width=500&amp;height=560&amp;small_header=true&amp;adapt_container_width=true&amp;hide_cover=false&amp;show_facepile=false"
                    title="UCC Jamaica Facebook timeline"
                    width="500"
                    height="560"
                    style="border: 0; overflow: hidden"
                    scrolling="no"
                    frameborder="0"
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                ></iframe>
                <p class="embed-note">Facebook may ask you to sign in to view some posts.</p>
            </article>

            <article class="social-feed-card social-feed-card-x">
                <header class="social-feed-header">
                    <div>
                        <p class="eyebrow">X · formerly Twitter</p>
                        <h2>UCC Jamaica</h2>
                    </div>
                    <a href="https://x.com/uccjamaica" target="_blank" rel="noopener noreferrer">Open profile <span aria-hidden="true">&nearr;</span></a>
                </header>
                <div class="x-feed-container">
                    <a
                        class="twitter-timeline"
                        data-height="560"
                        data-dnt="true"
                        href="https://twitter.com/uccjamaica?ref_src=twsrc%5Etfw"
                    >Posts by UCC Jamaica</a>
                </div>
                <p class="embed-note">If the timeline is unavailable, view the UCC profile on X.</p>
            </article>

            <article class="social-feed-card social-feed-card-instagram">
                <header class="social-feed-header">
                    <div>
                        <p class="eyebrow">Instagram</p>
                        <h2>UCC Jamaica</h2>
                    </div>
                    <a href="https://www.instagram.com/uccjamaica/" target="_blank" rel="noopener noreferrer">Open profile <span aria-hidden="true">&nearr;</span></a>
                </header>
                <div class="instagram-profile">
                    <span class="instagram-mark" aria-hidden="true">IG</span>
                    <p class="instagram-handle">@uccjamaica</p>
                    <p>University of the Commonwealth Caribbean. Explore UCC photos, videos, and updates on Instagram.</p>
                    <a class="button button-primary" href="https://www.instagram.com/uccjamaica/" target="_blank" rel="noopener noreferrer">View UCC on Instagram <span aria-hidden="true">&nearr;</span></a>
                </div>
                <p class="embed-note">Instagram's official embeds support individual public posts, not profile timelines. Visit the profile to browse current posts.</p>
            </article>
        </div>
    </section>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection

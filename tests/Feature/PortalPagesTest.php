<?php

namespace Tests\Feature;

use Database\Seeders\CourseSeeder;
use Database\Seeders\StaffSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PortalPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->seed([
            CourseSeeder::class,
            StaffSeeder::class,
        ]);
    }

    public function test_public_pages_share_navigation_and_email_action(): void
    {
        $home = $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('staff.index'))
            ->assertSee(route('courses.index'))
            ->assertSee(route('admissions'))
            ->assertSee(route('contact'))
            ->assertSee(route('social'));

        $home->assertSee('href="mailto:hod.it@ucc.edu.jm"', false);
        $home->assertSee('rel="manifest"', false)
            ->assertSee('navigator.serviceWorker.register', false);

        foreach ([
            route('home'),
            route('courses.index'),
            route('staff.index'),
            route('admissions'),
            route('contact'),
            route('social'),
        ] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('href="mailto:hod.it@ucc.edu.jm"', false)
                ->assertSee('rel="manifest"', false)
                ->assertSee('navigator.serviceWorker.register', false)
                ->assertSee('Social media');
        }

        $this->get(route('courses.index'))
            ->assertSee('ITT101')
            ->assertSee('Computer Information Systems')
            ->assertSee(route('courses.show', ['course' => 'ITT101']));

        $this->get(route('staff.index'))
            ->assertSee('Mrs. Marcia Campbell')
            ->assertSee('staff_hod.jpg')
            ->assertSee('mailto:hod.it@ucc.edu.jm', false)
            ->assertSee('tel:8769063000', false);
    }

    public function test_course_details_are_resolved_by_course_code(): void
    {
        $this->get(route('courses.show', ['course' => 'ITT101']))
            ->assertOk()
            ->assertSee('Computer Information Systems')
            ->assertSee('Introduction to computer hardware and software.')
            ->assertSee('3');

        $this->get('/courses/UNKNOWN')
            ->assertNotFound();
    }

    public function test_social_page_embeds_supported_platform_feeds_and_links_instagram(): void
    {
        $this->get(route('social'))
            ->assertOk()
            ->assertSee('plugins/page.php', false)
            ->assertSee('platform.twitter.com/widgets.js', false)
            ->assertSee('twitter.com/uccjamaica', false)
            ->assertSee('Instagram\'s official embeds support individual public posts, not profile timelines.', false)
            ->assertSee('https://www.instagram.com/uccjamaica/', false);
    }

    public function test_contact_form_saves_a_valid_message(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'Jordan Student',
            'email' => 'jordan@example.com',
            'subject' => 'Question about IT courses',
            'message' => 'I have a question about the next course registration period.',
        ])->assertRedirect(route('contact'));

        $this->assertDatabaseHas('messages', [
            'name' => 'Jordan Student',
            'email' => 'jordan@example.com',
            'subject' => 'Question about IT courses',
        ]);
    }

    public function test_contact_form_rejects_a_message_outside_the_length_limit(): void
    {
        $this->from(route('contact'))
            ->post(route('contact.store'), [
                'name' => 'Jordan Student',
                'email' => 'jordan@example.com',
                'subject' => 'Question',
                'message' => 'Short',
            ])
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors('message');

        $this->assertDatabaseCount('messages', 0);
    }

    public function test_pwa_manifest_icons_and_offline_page_are_configured(): void
    {
        $manifest = json_decode(file_get_contents(public_path('manifest.json')), true, flags: JSON_THROW_ON_ERROR);

        $this->assertSame('UCC IT Portal', $manifest['name']);
        $this->assertSame('UCC IT', $manifest['short_name']);
        $this->assertSame('#087f82', $manifest['theme_color']);
        $this->assertSame('#f5f8fa', $manifest['background_color']);
        $this->assertContains('192x192', array_column($manifest['icons'], 'sizes'));
        $this->assertContains('512x512', array_column($manifest['icons'], 'sizes'));
        foreach ($manifest['icons'] as $icon) {
            $dimensions = getimagesize(public_path($icon['src']));

            $this->assertSame($icon['sizes'], $dimensions[0].'x'.$dimensions[1]);
        }
        $this->assertStringContainsString("You're offline", file_get_contents(public_path('offline.html')));
    }

    public function test_authentication_page_includes_pwa_metadata_and_service_worker(): void
    {
        $this->withoutVite()
            ->get(route('login'))
            ->assertOk()
            ->assertSee('rel="manifest"', false)
            ->assertSee('navigator.serviceWorker.register', false);
    }
}

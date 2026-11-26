<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Message;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminAreaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Storage::fake('public');
    }

    public function test_admin_routes_require_authentication(): void
    {
        $course = Course::create([
            'code' => 'ITT101',
            'name' => 'Computer Information Systems',
            'credits' => 3,
            'description' => 'Introduction to computing.',
        ]);
        $staff = Staff::create([
            'name' => 'Test Staff',
            'position' => 'Lecturer',
            'phone' => '876-555-0100',
            'email' => 'staff@example.com',
            'photo' => 'staff/test.jpg',
        ]);

        foreach ([
            route('admin.dashboard'),
            route('admin.courses.index'),
            route('admin.courses.create'),
            route('admin.courses.edit', $course),
            route('admin.staff.index'),
            route('admin.messages.index'),
        ] as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }

        $this->delete(route('admin.courses.destroy', $course))->assertRedirect(route('login'));
        $this->delete(route('admin.staff.destroy', $staff))->assertRedirect(route('login'));
    }

    public function test_authenticated_staff_can_open_admin_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Admin dashboard');

        $this->get(route('admin.courses.index'))->assertOk();
        $this->get(route('admin.courses.create'))->assertOk()->assertSee('Add course');
        $this->get(route('admin.staff.index'))->assertOk()->assertSee('Add a staff member');
        $this->get(route('admin.messages.index'))->assertOk()->assertSee('Contact messages');
    }

    public function test_staff_can_create_update_and_delete_courses(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.courses.store'), [
            'code' => 'itt550',
            'name' => 'Systems Design',
            'credits' => '3',
            'prerequisites' => '',
            'description' => 'An introduction to systems design.',
        ])->assertRedirect(route('admin.courses.index'));

        $course = Course::where('code', 'ITT550')->firstOrFail();
        $this->assertNull($course->prerequisites);

        $this->put(route('admin.courses.update', $course), [
            'code' => $course->code,
            'name' => 'Advanced Systems Design',
            'credits' => '4',
            'prerequisites' => 'ITT301',
            'description' => 'Advanced concepts in systems design.',
        ])->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Advanced Systems Design',
            'credits' => 4,
            'prerequisites' => 'ITT301',
        ]);

        $this->delete(route('admin.courses.destroy', $course))
            ->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_course_form_request_enforces_existing_code_credit_and_uniqueness_rules(): void
    {
        $this->actingAs(User::factory()->create());

        Course::create([
            'code' => 'ITT101',
            'name' => 'Computer Information Systems',
            'credits' => 3,
            'description' => 'Introduction to computing.',
        ]);

        $this->from(route('admin.courses.create'))
            ->post(route('admin.courses.store'), [
                'code' => 'IT101',
                'name' => 'Invalid code',
                'credits' => 5,
                'prerequisites' => '',
                'description' => 'An invalid course.',
            ])
            ->assertRedirect(route('admin.courses.create'))
            ->assertSessionHasErrors(['code', 'credits']);

        $this->from(route('admin.courses.create'))
            ->post(route('admin.courses.store'), [
                'code' => 'ITT101',
                'name' => 'Duplicate code',
                'credits' => 3,
                'prerequisites' => '',
                'description' => 'A duplicate course.',
            ])
            ->assertRedirect(route('admin.courses.create'))
            ->assertSessionHasErrors('code');

        $this->assertDatabaseCount('courses', 1);
    }

    public function test_staff_photos_are_stored_and_removed_with_the_staff_record(): void
    {
        $this->actingAs(User::factory()->create());
        $image = UploadedFile::fake()->createWithContent(
            'lecturer.jpg',
            file_get_contents(base_path('uploads/staff_hod.jpg')),
        );

        $this->post(route('admin.staff.store'), [
            'name' => 'New Lecturer',
            'position' => 'Lecturer',
            'phone' => '876-555-0199',
            'email' => 'lecturer@example.com',
            'photo' => $image,
        ])->assertRedirect(route('admin.staff.index'));

        $staff = Staff::where('email', 'lecturer@example.com')->firstOrFail();
        $photoPath = $staff->photo;

        $this->assertStringStartsWith('staff/', $photoPath);
        Storage::disk('public')->assertExists($photoPath);
        $this->get(route('admin.staff.index'))->assertSee('New Lecturer');

        $this->delete(route('admin.staff.destroy', $staff))
            ->assertRedirect(route('admin.staff.index'));

        $this->assertDatabaseMissing('staff', ['id' => $staff->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_admin_messages_are_ordered_newest_first(): void
    {
        $this->actingAs(User::factory()->create());

        Carbon::setTestNow('2026-01-01 10:00:00');
        Message::create([
            'name' => 'Older sender',
            'email' => 'older@example.com',
            'subject' => 'Older message',
            'message' => 'An older contact message.',
        ]);
        Carbon::setTestNow('2026-01-01 10:02:00');
        Message::create([
            'name' => 'Newer sender',
            'email' => 'newer@example.com',
            'subject' => 'Newer message',
            'message' => 'A newer contact message.',
        ]);
        Carbon::setTestNow();

        $this->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSeeInOrder(['Newer message', 'Older message']);
    }
}

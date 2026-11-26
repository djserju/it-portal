<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_seeds_existing_portal_data_idempotently(): void
    {
        config(['hashing.bcrypt.rounds' => 12]);
        Storage::fake('public');

        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('courses', 10);
        $this->assertDatabaseCount('staff', 5);
        $this->assertDatabaseCount('messages', 0);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('courses', [
            'code' => 'ITT101',
            'name' => 'Computer Information Systems',
        ]);
        $this->assertDatabaseHas('staff', [
            'email' => 'hod.it@ucc.edu.jm',
            'photo' => 'staff/staff_hod.jpg',
        ]);
        Storage::disk('public')->assertExists('staff/staff_hod.jpg');

        $admin = User::where('email', 'admin@ucc.edu.jm')->firstOrFail();

        $this->assertNotNull($admin->email_verified_at);
        $this->assertSame('bcrypt', password_get_info($admin->password)['algoName']);
    }
}

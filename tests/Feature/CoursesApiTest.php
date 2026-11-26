<?php

namespace Tests\Feature;

use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoursesApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_courses_api_returns_all_courses_as_json(): void
    {
        $this->seed(CourseSeeder::class);

        $this->getJson('/api/courses')
            ->assertOk()
            ->assertJsonCount(10)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'code',
                    'name',
                    'credits',
                    'prerequisites',
                    'description',
                    'created_at',
                ],
            ])
            ->assertJsonFragment([
                'code' => 'ITT101',
                'name' => 'Computer Information Systems',
                'credits' => 3,
                'prerequisites' => null,
            ]);
    }
}

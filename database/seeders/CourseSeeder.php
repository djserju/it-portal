<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['code' => 'ITT101', 'name' => 'Computer Information Systems', 'credits' => 3, 'prerequisites' => null, 'description' => 'Introduction to computer hardware and software.'],
            ['code' => 'ITT102', 'name' => 'Programming Techniques', 'credits' => 3, 'prerequisites' => 'ITT101', 'description' => 'Fundamentals of structured programming.'],
            ['code' => 'ITT200', 'name' => 'Object-Oriented Programming', 'credits' => 3, 'prerequisites' => 'ITT102', 'description' => 'Principles of OOP.'],
            ['code' => 'ITT201', 'name' => 'Data Structures and File Management', 'credits' => 3, 'prerequisites' => 'ITT200', 'description' => 'Design and implementation of arrays, stacks and queues.'],
            ['code' => 'ITT202', 'name' => 'Internet Authoring I', 'credits' => 3, 'prerequisites' => 'ITT101', 'description' => 'Client-side web development using HTML5.'],
            ['code' => 'ITT301', 'name' => 'Database Management Systems', 'credits' => 3, 'prerequisites' => 'ITT201', 'description' => 'Relational database design, normalization and SQL quering.'],
            ['code' => 'ITT302', 'name' => 'Computer Networks and Data Communications', 'credits' => 3, 'prerequisites' => 'ITT101', 'description' => 'OSI and TCP/IP models, routing, switching and network protocols.'],
            ['code' => 'ITT303', 'name' => 'Internet Authoring II', 'credits' => 3, 'prerequisites' => 'ITT202', 'description' => 'Server-side web application development using PHP and MySQL.'],
            ['code' => 'ITT401', 'name' => 'Information Systems Security', 'credits' => 3, 'prerequisites' => 'ITT302', 'description' => 'Cybersecurity principles, cryptography, risk management and network defense.'],
            ['code' => 'ITT402', 'name' => 'Software Engineering', 'credits' => 3, 'prerequisites' => 'ITT301', 'description' => 'Software development life cycle, agile methodologies and system testing.'],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(['code' => $course['code']], $course);
        }
    }
}

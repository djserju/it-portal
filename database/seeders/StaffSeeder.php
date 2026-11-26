<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staffMembers = [
            ['name' => 'Mrs. Marcia Campbell', 'position' => 'Head of Department (IT)', 'phone' => '876-906-3000', 'email' => 'hod.it@ucc.edu.jm', 'photo' => 'staff_hod.jpg'],
            ['name' => 'Mr. Devon Brown', 'position' => 'Senior Lecturer - Software Engineering', 'phone' => '876-906-3011', 'email' => 'dbrown@ucc.edu.jm', 'photo' => 'staff_brown.jpg'],
            ['name' => 'Ms. Simone Reid', 'position' => 'Lecturer - Database & Web Systems', 'phone' => '876-906-3012', 'email' => 'sreid@ucc.edu.jm', 'photo' => 'staff_reid.jpg'],
            ['name' => 'Mr. Andre Grant', 'position' => 'Lecturer - Networking & Security', 'phone' => '876-906-3013', 'email' => 'agrant@ucc.edu.jm', 'photo' => 'staff_grant.jpg'],
            ['name' => 'Mrs. Keisha Thompson', 'position' => 'Departmental Administrative Assistant', 'phone' => '876-906-3014', 'email' => 'kthompson@ucc.edu.jm', 'photo' => 'staff_thompson.jpg'],
        ];

        foreach ($staffMembers as $staffMember) {
            $source = base_path('uploads/'.$staffMember['photo']);

            if (! File::exists($source)) {
                throw new RuntimeException("The staff photo [{$staffMember['photo']}] is missing.");
            }

            $photoPath = 'staff/'.$staffMember['photo'];

            if (! Storage::disk('public')->put($photoPath, File::get($source))) {
                throw new RuntimeException("The staff photo [{$staffMember['photo']}] could not be stored.");
            }

            $staffMember['photo'] = $photoPath;

            Staff::updateOrCreate(['email' => $staffMember['email']], $staffMember);
        }
    }
}

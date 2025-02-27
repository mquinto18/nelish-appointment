<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Therapist;

class TherapistSeeder extends Seeder
{
    public function run(): void
    {
        Therapist::insert([
            [
                'name' => 'Dr. John Smith',
                'bio' => 'Expert in physical therapy with 10+ years of experience.',
                'phone' => '123-456-7890',
                'email' => 'john.smith@example.com',
                'experience' => 10,
                'language' => 'English, Spanish',
            ],
            [
                'name' => 'Dr. Maria Lopez',
                'bio' => 'Specialist in mental health and counseling.',
                'phone' => '987-654-3210',
                'email' => 'maria.lopez@example.com',
                'experience' => 8,
                'language' => 'English, French',
            ],
            [
                'name' => 'Dr. Ethan Brown',
                'bio' => 'Sports rehabilitation therapist with experience in injury recovery.',
                'phone' => '456-789-1234',
                'email' => 'ethan.brown@example.com',
                'experience' => 12,
                'language' => 'English',
            ],
            [
                'name' => 'Dr. Sofia Martinez',
                'bio' => 'Licensed massage therapist focused on relaxation therapy.',
                'phone' => '789-123-4567',
                'email' => 'sofia.martinez@example.com',
                'experience' => 7,
                'language' => 'Spanish, English',
            ],
            [
                'name' => 'Dr. Liam Chen',
                'bio' => 'Cognitive behavioral therapist helping clients with stress management.',
                'phone' => '321-654-9870',
                'email' => 'liam.chen@example.com',
                'experience' => 9,
                'language' => 'Mandarin, English',
            ],
            [
                'name' => 'Dr. Ava Johnson',
                'bio' => 'Holistic therapy expert using mindfulness techniques.',
                'phone' => '654-321-7890',
                'email' => 'ava.johnson@example.com',
                'experience' => 6,
                'language' => 'English, German',
            ],
        ]);
    }
}


<?php

namespace Database\Seeders;

use App\Models\EventTag;
use Illuminate\Database\Seeder;

class EventTagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Science', 'Mathematics', 'Literature', 'History', 'Art', 'Music',
            'Football', 'Basketball', 'Volleyball', 'Track & Field', 'Swimming',
            'Dance', 'Drama', 'Festival', 'Celebration', 'Competition',
            'Workshop', 'Seminar', 'Conference', 'Training', 'Career',
            'Community Service', 'Fundraiser', 'Charity', 'Volunteer',
            'Christmas', 'New Year', 'Independence Day', 'School Anniversary',
            'Graduation', 'Orientation', 'Parent-Teacher Meeting'
        ];

        foreach ($tags as $tagName) {
            EventTag::create(['name' => $tagName]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Academic', 'description' => 'Educational events and academic activities'],
            ['name' => 'Sports', 'description' => 'Athletic competitions and sports events'],
            ['name' => 'Arts & Culture', 'description' => 'Cultural events, performances, and exhibitions'],
            ['name' => 'Community', 'description' => 'Community service and social events'],
            ['name' => 'Holiday', 'description' => 'Holiday celebrations and special occasions'],
            ['name' => 'Administrative', 'description' => 'School administrative meetings and orientations'],
            ['name' => 'Fundraising', 'description' => 'Charity events and fundraising activities'],
            ['name' => 'Professional Development', 'description' => 'Workshops and training sessions']
        ];

        foreach ($categories as $category) {
            EventCategory::create($category);
        }
    }
}

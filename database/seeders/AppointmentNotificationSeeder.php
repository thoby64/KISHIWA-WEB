<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::whereIn('role', ['admin', 'manager'])->get();
        foreach ($users as $user) {
            \App\Models\AppointmentNotification::firstOrCreate(['user_id' => $user->id]);
        }
    }
}

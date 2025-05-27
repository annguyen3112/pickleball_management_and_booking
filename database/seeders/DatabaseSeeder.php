<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserRole;
use App\Models\BankInformation;
use App\Models\FootballPitch;
use App\Models\FootballPitchDetail;
use App\Models\PeakHour;
use App\Models\PitchType;
use App\Models\Provider;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        PitchType::create([
            'quantity' => 7,
            'description' => '14 người, mỗi đội 7 người',
        ]);
        PitchType::create([
            'quantity' => 11,
            'description' => '22 người, mỗi đội 11 người',
        ]);
        // Provider::create([
        //     'name' => 'google',
        // ]);
        // Provider::create([
        //     'name' => 'facebook',
        // ]);
        // BankInformation::create([
        //     'name' => '',
        //     'bank_number' => '',
        //     'bank' => '',
        // ]);
        PeakHour::create([
            'start_at' => '17:00:00',
            'end_at' => '22:00:00',
        ]);
        User::create([
            'name' => '',
            'phone' => '098999999',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123123'),
            'address' => '',
            'role' => UserRole::CourtOwner,
        ]);
        User::create([
            'name' => 'System Admin',
            'phone' => '0000000000',
            'email' => 'systemadmin@admin.com',
            'password' => Hash::make('123123123'),
            'address' => '',
            'role' => UserRole::SystemAdmin,
        ]);
        // for ($i = 1; $i <= 5; $i++) {
        //     FootballPitch::create([
        //         'name' => 'Sân ' . $i,
        //         'time_start' => '7:00:00',
        //         'time_end' => '22:00:00',
        //         'price_per_hour' => '500000',
        //         'price_per_peak_hour' => '600000',
        //         'pitch_type_id' => 1,
        //     ]);
        // }
        // FootballPitch::create([
        //     'name' => 'Sân 1 + 2',
        //     'time_start' => '7:00:00',
        //     'time_end' => '22:00:00',
        //     'price_per_hour' => '1000000',
        //     'price_per_peak_hour' => '1200000',
        //     'pitch_type_id' => 2,
        //     'from_football_pitch_id' => 1,
        //     'to_football_pitch_id' => 2,
        // ]);
        // FootballPitch::create([
        //     'name' => 'Sân 3 + 4',
        //     'time_start' => '7:00:00',
        //     'time_end' => '22:00:00',
        //     'price_per_hour' => '1000000',
        //     'price_per_peak_hour' => '1200000',
        //     'pitch_type_id' => 2,
        //     'from_football_pitch_id' => 3,
        //     'to_football_pitch_id' => 4,
        // ]);

        // FootballPitchDetail::create([
        //     'football_pitch_id' => 1,
        //     'image' => 'images/football_pitches/sb1.jpg',
        // ]);
        // FootballPitchDetail::create([
        //     'football_pitch_id' => 1,
        //     'image' => 'images/football_pitches/sb2.jpg',
        // ]);
        // Equipment::create([
        //     'name' => 'Vợt Facolos',
        //     'price' => '50000',
        //     'equipment_type_id' => 2,
        // ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\FootballPitch;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_book_pitch()
    {
        $pitch = FootballPitch::factory()->create();

        $response = $this->postJson('/api/client_store', [
            'football_pitch_id' => $pitch->id,
            'start_at' => now()->addDays(1)->format('Y-m-d H:00:00'),
            'end_at' => now()->addDays(1)->addHours(1)->format('Y-m-d H:00:00'),
            'name' => 'Test User',
            'phone' => '0123456777',
            'email' => 'testuser@gmail.com',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('bookings', [
            'football_pitch_id' => $pitch->id,
            'name' => 'Test User',
            'phone' => '0123456777',
        ]);
    }
}

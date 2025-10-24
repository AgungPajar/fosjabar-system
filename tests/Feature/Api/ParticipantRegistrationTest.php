<?php

namespace Tests\Feature\Api;

use App\Models\Generation;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ParticipantRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_participant_can_register_successfully(): void
    {
        $generation = Generation::create([
            'id' => (string) Str::uuid(),
            'name' => 'Batch 1',
            'singkatan' => 'B1',
            'started_at' => now()->subMonth()->toDateString(),
            'ended_at' => now()->addMonth()->toDateString(),
            'is_active' => true,
        ]);

        $payload = [
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'no_hp' => '08123456789',
            'birthday' => '2000-01-01',
            'from_school' => 'ABC High School',
            'photo' => 'photos/john.jpg',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'generations_id' => $generation->id,
        ];

        $response = $this->postJson(route('api.participants.register'), $payload);

        $response->assertCreated()
            ->assertJson([
                'message' => 'Pendaftaran peserta berhasil.',
                'data' => [
                    'name' => 'John Doe',
                    'username' => 'johndoe',
                    'email' => 'john@example.com',
                    'no_hp' => '08123456789',
                    'from_school' => 'ABC High School',
                    'photo' => 'photos/john.jpg',
                    'generations_id' => $generation->id,
                ],
            ]);

        $this->assertDatabaseCount('participants', 1);

        $participant = Participant::first();
        $this->assertNotNull($participant);
        $this->assertTrue(Hash::check('secret123', $participant->password));
    }

    public function test_registration_requires_password_confirmation(): void
    {
        $payload = [
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'no_hp' => '0811111111',
            'password' => 'secret123',
            // missing confirmation intentionally
        ];

        $response = $this->postJson(route('api.participants.register'), $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }
}

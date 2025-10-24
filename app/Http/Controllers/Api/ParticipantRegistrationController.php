<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParticipantRegistrationController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('participants', 'username')],
            'email' => ['required', 'email', 'max:255', Rule::unique('participants', 'email')],
            'no_hp' => ['required', 'string', 'max:30'],
            'birthday' => ['nullable', 'date'],
            'from_school' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'generations_id' => ['nullable', 'uuid', Rule::exists('generations', 'id')],
        ]);

        $participant = DB::transaction(function () use ($validated) {
            $validated['password'] = Hash::make($validated['password']);

            return Participant::create($validated);
        });

        return response()->json([
            'message' => 'Pendaftaran peserta berhasil.',
            'data' => [
                'id' => $participant->id,
                'name' => $participant->name,
                'username' => $participant->username,
                'email' => $participant->email,
                'no_hp' => $participant->no_hp,
                'birthday' => optional($participant->birthday)->toDateString(),
                'from_school' => $participant->from_school,
                'photo' => $participant->photo,
                'generations_id' => $participant->generations_id,
            ],
        ], 201);
    }
}

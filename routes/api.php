<?php

use App\Http\Controllers\Api\ParticipantRegistrationController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function (): void {
    Route::post('participants/register', [ParticipantRegistrationController::class, 'register'])
        ->name('api.participants.register');
});

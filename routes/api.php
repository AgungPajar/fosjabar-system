<?php

use App\Http\Controllers\Api\ParticipantRegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('participants')->group(function () {
    Route::post('/register', [ParticipantRegistrationController::class, 'register']);
});
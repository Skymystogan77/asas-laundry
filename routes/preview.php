<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/preview/auto-login/{role}', function ($role) {
    $user = User::where('role', $role)->first();
    if ($user) {
        Auth::login($user);
    }
    return redirect()->route('dashboard');
});

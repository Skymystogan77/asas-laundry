<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Auto-login then redirect to any page
// Usage: /preview/auto-login/admin?goto=/layanan
Route::get('/preview/auto-login/{role}', function ($role) {
    $user = User::where('role', $role)->first();
    if ($user) {
        Auth::login($user, true);
        session()->regenerate();
    }
    $goto = request()->query('goto', '/dashboard');
    return redirect($goto);
});

<?php

namespace App\Services\Auth;

use App\Models\User;

class AuthService
{
    public function getAuthToken(User $user)
    {
        return $user->createToken('authToken')->accessToken;
    }
}

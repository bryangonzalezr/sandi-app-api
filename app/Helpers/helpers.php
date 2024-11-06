<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (! function_exists('current_user')) {
    function current_user(): ?User
    {
        return Auth::user();
    }
}



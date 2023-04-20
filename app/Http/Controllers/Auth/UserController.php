<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        Auth::attempt(['email' => request('email'), 'password' => request('password')], true);

        return UserResource::make(Auth::user());
    }
}

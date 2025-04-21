<?php

namespace App\Http\Controllers;

use Laravel\Passport\Passport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    public function login(Request $request, string $entity)
    {
        $validated = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $entity = strtoupper($entity);

        return Http::asForm()->post(env('APP_URL') . '/oauth/token', [
            'grant_type'        => 'password',
            'client_id'         => env("PASSPORT_{$entity}_PERSONAL_ACCESS_CLIENT_ID"),
            'client_secret'     => env("PASSPORT_{$entity}_PERSONAL_ACCESS_CLIENT_SECRET"),
            'username'          => $validated['email'],
            'password'          => $validated['password'],
            'scope'             => '*',

        ])->json();
    }
}

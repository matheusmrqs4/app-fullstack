<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request, User $user)
    {
        $userData = $request->only('name', 'email', 'password');
        $userData['password'] = bcrypt($userData['password']);

        if (!$user = $user->create($userData)) {
            abort(500, "Error to create new User");
        }

        auth()->login($user);

        $token = auth()->user()->createToken('auth-token');

        return response()
            ->json([
                'data' => [
                    'token' => $token->plainTextToken,
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                ]
            ]);
    }
}

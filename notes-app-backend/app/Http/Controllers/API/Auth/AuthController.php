<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            abort(401, 'Unauthorized');
        }

        $user = auth()->user();
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

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()
                ->json([], 204);
    }
}

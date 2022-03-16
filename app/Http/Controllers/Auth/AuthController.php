<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use function response;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if(! Auth::attempt($request->only(['email', 'password'])))
            return response()->json([
               'error' => 'Wrong credentials.'
            ], 422);

        $token = Auth::user()->createToken('user')->plainTextToken;

        return response()->json([
           'message' => 'success',
           'token' => $token
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json('',200);
    }
}

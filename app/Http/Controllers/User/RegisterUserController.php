<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use function response;

class RegisterUserController extends Controller
{
    public function  __invoke(RegisterUserRequest $request): JsonResponse
    {
        $request['password'] = Hash::make($request['password']);

        $user = User::query()
            ->create(
                $request->only([
                    'name',
                    'email',
                    'password'
                ])
            );

        if(!$user)
            return response()->json([
               'message' => 'server error'
            ], 500);

        return response()->json([
            'message' => 'success',
            'data' => [
                'name' => $user['name'],
                'email' => $user['email'],
                'id' => $user->id
            ]
        ], 201);
    }
}

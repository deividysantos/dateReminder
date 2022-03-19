<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class RegisterUserController extends Controller
{
    public function  __invoke(RegisterUserRequest $request): JsonResponse
    {
        $request['password'] = Hash::make($request['password']);

        try {
            $user = User::query()
                ->create($request->only([
                        'name',
                        'email',
                        'password'
                    ]
                )
            );
        }catch (\Exception $e){
            return response()->json([
                'message' => 'server error'
            ], 500);
        }

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

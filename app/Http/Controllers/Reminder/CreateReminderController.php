<?php

namespace App\Http\Controllers\Reminder;

use App\Http\Requests\Reminder\CreateReminderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Reminder;

class CreateReminderController extends Controller
{
    public function __invoke(CreateReminderRequest $request): JsonResponse
    {
         $credentials = [
             'friend_name' => $request['friend_name'],
             'date' => $request['date'],
             'user_id' => Auth::user()->id
         ];

        try {
            $reminder = Reminder::query()->create($credentials);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'server error'
            ], 500);
        }

         return response()->json([
             'message' => 'success',
             'data' => [
                 'friend_name' => $reminder->friend_name,
                 'date' => $reminder->date,
                 'id' => $reminder->id
             ]
         ], 201);
    }
}

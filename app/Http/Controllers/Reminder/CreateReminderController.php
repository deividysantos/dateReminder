<?php

namespace App\Http\Controllers\Reminder;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReminderRequest;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function response;

class CreateReminderController extends Controller
{
    public function __invoke(CreateReminderRequest $request)
    {
         $credentials = [
             'friend_name' => $request['friend_name'],
             'date' => $request['date'],
             'user_id' => Auth::user()->id
         ];

         if(! $reminder = Reminder::query()->create($credentials))
             return response()->json([
                 'message' => 'server error'
             ], 500);

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

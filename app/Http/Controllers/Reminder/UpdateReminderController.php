<?php

namespace App\Http\Controllers\Reminder;

use App\Http\Requests\Reminder\UpdateReminderRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Reminder;

class UpdateReminderController extends Controller
{
    public function __invoke(UpdateReminderRequest $request, Reminder $reminder): JsonResponse
    {
        if(!Auth::user()->can('update', $reminder))
            return response()->json([
                'error' => 'This resource does not belongs for this user.'
            ], 403);

        try {

            $reminder->update($request->only(['friend_name', 'date']));

        }catch (\Exception $e){
            return response()->json([
                'error' => 'server error'
            ], 500);
        }

        return response()->json([
           'message' => 'success',
            'data' => [
                'friend_name' => $reminder->friend_name,
                'date' => $reminder->date
            ]
        ]);
    }
}

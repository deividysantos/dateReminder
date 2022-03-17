<?php

namespace App\Http\Controllers\Reminder;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateReminderController extends Controller
{
    public function __invoke(Request $request , Reminder $reminder): JsonResponse
    {
        if(!Auth::user()->can('update', $reminder))
            return response()->json([
                'error' => 'This resource does not belongs for this user.'
            ], 403);

        $request->validate([
            'friend_name' => ['required', 'max:255'],
            'date' => ['required', 'date_format:d/m/Y']
        ]);

        if(!$reminder->update($request->only(['friend_name', 'date'])))
            return response()->json([
                'error' => 'server error'
            ], 500);

        return response()->json([
           'message' => 'success',
            'data' => [
                'friend_name' => $reminder->friend_name,
                'date' => $reminder->date
            ]
        ]);
    }
}

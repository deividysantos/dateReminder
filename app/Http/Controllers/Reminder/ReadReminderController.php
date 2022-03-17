<?php

namespace App\Http\Controllers\Reminder;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;

class ReadReminderController extends Controller
{
    public function getAll()
    {
        $userId = Auth::user()->id;

        return Reminder::query()
            ->select('friend_name', 'date')
            ->when(['user_id' => $userId])
            ->get();
    }

    public function getById(Reminder $reminder)
    {
        $this->authorize('read', $reminder);

        return response()->json([
            'friend_name' => $reminder->friend_name,
            'date' => $reminder->date
        ]);
    }
}

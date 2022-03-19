<?php

namespace App\Http\Controllers\Reminder;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Models\Reminder;

class ReadReminderController extends Controller
{
    public function getAll(): Collection|array
    {
        $userId = Auth::user()->id;

        return Reminder::query()
            ->select('friend_name', 'date')
            ->when(['user_id' => $userId])
            ->get();
    }

    public function getById(Reminder $reminder): JsonResponse
    {
        $this->authorize('read', $reminder);

        return response()->json([
            'friend_name' => $reminder->friend_name,
            'date' => $reminder->date
        ]);
    }
}

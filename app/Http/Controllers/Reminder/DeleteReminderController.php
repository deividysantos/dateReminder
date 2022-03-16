<?php

namespace App\Http\Controllers\Reminder;

use App\Http\Controllers\Controller;
use App\Models\Reminder;

class DeleteReminderController extends Controller
{

    public function __invoke(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        $reminder->delete();

        return response()->json([
           'message' => 'success'
        ]);
    }
}

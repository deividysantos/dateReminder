<?php

namespace App\Policies;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReminderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Reminder $reminder)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Reminder $reminder)
    {
        return $user->id == $reminder->user_id;
    }
}

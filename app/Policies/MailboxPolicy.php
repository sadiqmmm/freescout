<?php

namespace App\Policies;

use App\User;
use App\Mailbox;
use Illuminate\Auth\Access\HandlesAuthorization;

class MailboxPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the mailbox.
     *
     * @param  \App\User  $user
     * @param  \App\Mailbox  $mailbox
     * @return mixed
     */
    public function view(User $user, Mailbox $mailbox)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return $user->mailboxes->contains($mailbox));
        }
    }

    /**
     * Determine whether the user can create mailboxes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the mailbox.
     *
     * @param  \App\User  $user
     * @param  \App\Mailbox  $mailbox
     * @return mixed
     */
    public function update(User $user, Mailbox $mailbox)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the mailbox.
     *
     * @param  \App\User  $user
     * @param  \App\Mailbox  $mailbox
     * @return mixed
     */
    public function delete(User $user, Mailbox $mailbox)
    {
        if ($user->isAdmin()) {
            return true;
        } else {
            return false;
        }
    }
}

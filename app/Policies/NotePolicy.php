<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NotePolicy
{
    /**
     * Determine whether the user can view any models.
     * @param User|Admin $user
     * @return bool
     */
    public function viewAny(User|Admin $user): bool
    {
        return modelIsAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     * @param User|Admin $user
     * @param Note $note
     * @return bool
     */
    public function view(User|Admin $user, Note $note): bool
    {
        return modelIsAdmin($user) || ($user->id === $note->user_id);
    }

    /**
     * Determine whether the user can create models.
     * @param User|Admin $user
     * @return bool
     */
    public function create(User|Admin $user): bool
    {
        return modelIsAdmin($user) || $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can update the model.
     * @param User|Admin $user
     * @param Note $note
     * @return bool
     */
    public function update(User|Admin $user, Note $note): bool
    {
        return modelIsAdmin($user) || ($user->id === $note->user_id);
    }

    /**
     * Determine whether the user can delete the model.
     * @param User|Admin $user
     * @param Note $note
     * @return bool
     */
    public function delete(User|Admin $user, Note $note): bool
    {
        return modelIsAdmin($user) || ($user->id === $note->user_id);
    }

    /**
     * Determine whether the user can restore the model.
     * @param User|Admin $user
     * @param Note $note
     * @return bool
     */
    public function restore(User|Admin $user, Note $note): bool
    {
        return modelIsAdmin($user) || ($user->id === $note->user_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User|Admin $user
     * @param Note $note
     * @return bool
     */
    public function forceDelete(User|Admin $user, Note $note): bool
    {
        return modelIsAdmin($user) || ($user->id === $note->user_id);
    }
}

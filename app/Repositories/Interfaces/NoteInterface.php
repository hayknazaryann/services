<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Repositories\Eloquent\EloquentInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface NoteInterface extends EloquentInterface
{
    /**
     * @param User $user
     * @return LengthAwarePaginator
     */
    public function getUserNotes(User $user): LengthAwarePaginator;
}

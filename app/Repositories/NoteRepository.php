<?php

namespace App\Repositories;

use App\Models\Note;
use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Interfaces\NoteInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class NoteRepository extends EloquentRepository implements NoteInterface
{
    /**
     * NoteRepository constructor.
     * @param Note $note
     */
    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    /** @inheritDoc */
    public function getUserNotes(User $user): LengthAwarePaginator
    {
        return $this->getModelByOrder()
            ->where(['user_id' => $user->id])
            ->paginate(12);
    }

}

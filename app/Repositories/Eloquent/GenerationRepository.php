<?php

namespace App\Repositories\Eloquent;

use App\Models\Generation;
use App\Repositories\Interfaces\GenerationInterface;

class GenerationRepository extends EloquentRepository implements GenerationInterface
{
    /**
     * NoteRepository constructor.
     * @param Generation $generation
     */
    public function __construct(Generation $generation)
    {
        $this->model = $generation;
    }



}

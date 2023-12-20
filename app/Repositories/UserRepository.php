<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends EloquentRepository implements UserInterface
{
    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /** @inheritDoc */
    public function createToken(Model $model, string $tokenName): string
    {
        return $model->createToken('authToken')->plainTextToken;
    }
}

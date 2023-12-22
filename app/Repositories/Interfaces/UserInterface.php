<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Eloquent\EloquentInterface;
use Illuminate\Database\Eloquent\Model;

interface UserInterface extends EloquentInterface
{
    /**
     * @param Model $model
     * @param array $data
     * @return EloquentInterface
     */
    public function updateProfile(Model $model, array $data): EloquentInterface;

    /**
     * @param Model $model
     * @param string $tokenName
     * @return string
     */
    public function createToken(Model $model, string $tokenName): string;

    /**
     * @param Model $model
     * @param $password
     * @return bool
     */
    public function checkPassword(Model $model, $password): bool;
}

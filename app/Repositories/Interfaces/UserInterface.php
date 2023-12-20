<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Eloquent\EloquentInterface;
use Illuminate\Database\Eloquent\Model;

interface UserInterface extends EloquentInterface
{
    /**
     * @param Model $model
     * @param string $tokenName
     * @return string
     */
    public function createToken(Model $model, string $tokenName): string;
}

<?php

namespace App\Repositories\Eloquent;

use App\Models\CarModel;
use App\Repositories\Interfaces\ModelInterface;

class ModelRepository extends EloquentRepository implements ModelInterface
{
    /**
     * ModelRepository constructor.
     * @param CarModel $carModel
     */
    public function __construct(CarModel $carModel)
    {
        $this->model = $carModel;
    }



}

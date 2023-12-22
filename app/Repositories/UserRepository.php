<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Eloquent\EloquentInterface;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Interfaces\UserInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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
    public function create(array $data): Model
    {
        $user = $this->getModel()->query()->create($data);
        $user->profile()->create();
        return $user;
    }

    /** @inheritDoc */
    public function updateProfile(Model $model, array $data): EloquentInterface
    {
        $model->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name']
        ]);

        $model->profile()->update([
            'phone_code' => $data['phone_code'],
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'specialization' => $data['specialization'],
            'about' => $data['about'],
            'birthdate' => Carbon::parse($data['birthdate'])->addDay()->format('Y-m-d'),
        ]);

        return $this;
    }

    /** @inheritDoc */
    public function createToken(Model $model, string $tokenName): string
    {
        return $model->createToken('authToken')->plainTextToken;
    }

    /** @inheritDoc */
    public function checkPassword(Model $model, $password): bool
    {
        return Hash::check($password, $model->password);
    }

}

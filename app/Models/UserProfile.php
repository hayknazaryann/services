<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'user_profiles';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'specialization',
        'about',
        'avatar',
        'birthdate',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'market',
        'title',
        'generation',
        'period',
        'image',
        'link'
    ];
}

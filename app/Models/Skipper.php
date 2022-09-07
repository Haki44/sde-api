<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skipper extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'firstname',
        'picture',
        'description_fr',
        'description_en',
        'languages',
    ];

}

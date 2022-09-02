<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adventure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'level_id',
        'family',
        'price',
        'places',
        'available_places',
        'departure_date',
        'arrival_date',
        'description_fr',
        'description_en',
    ];

    protected $with = ['pictures'];


    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}

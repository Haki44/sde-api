<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description_fr',
        'description_en',
        'type_fr',
        'type_en',
        'displacements',
        'surface',
        'engine_power',
        'hull_fr',
        'hull_en',
        'deck_fr',
        'deck_en',
        'mast_fr',
        'mast_en',
        'architect',
        'diverse_fr',
        'diverse_en'
    ];

    protected $with = ['pictures', 'boatRentalPrices', 'boatBookings'];


    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }

    public function boatRentalPrices()
    {
        return $this->hasMany(BoatRentalPrice::class);
    }

    public function boatBookings()
    {
        return $this->hasMany(BoatBooking::class);
    }
}

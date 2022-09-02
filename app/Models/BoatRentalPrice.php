<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoatRentalPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'with_skipper',
        'boat_id',
        'period_id',
    ];

    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }

    public function period()
    {
        return $this->belongsTo(Period ::class);
    }
}

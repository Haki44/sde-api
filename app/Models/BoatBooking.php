<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoatBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'firstname',
        'nationality',
        'email',
        'tel',
        'start_date',
        'end_date',
        'with_skipper',
        'description',
        'user_id',
        'boat_id',
        'is_validate',
    ];

    protected $with = ['boats'];

    public function boats()
    {
        return $this->belongsTo(Boat::class);
    }
}

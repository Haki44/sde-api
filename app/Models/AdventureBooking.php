<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdventureBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'firstname',
        'nationality',
        'email',
        'tel',
        'places_needed',
        'description',
        'user_id',
        'adventure_id',
        'is_validate',
    ];

    protected $with = ['adventures'];

    public function adventures()
    {
        return $this->belongsTo(Adventure::class);
    }
}

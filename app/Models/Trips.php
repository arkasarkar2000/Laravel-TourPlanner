<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_to',
        'total_fare',
        'total_days',
        'from',
        'to',
        'members'
    ];
}

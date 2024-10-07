<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'reservation_date',
        'reservation_time', 
        'reservation_people',
    ];
}

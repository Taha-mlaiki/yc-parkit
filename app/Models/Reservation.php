<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        "user_id",
        "park_id",
        "start_date",
        "end_date",
        "status"
    ];
}

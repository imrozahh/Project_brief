<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
            'title',
            'description',
            'venue',
            'start_datetime',
            'end_datetime',
            'status',
            'organizer_id' 
    ];
}

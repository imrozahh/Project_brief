<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
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

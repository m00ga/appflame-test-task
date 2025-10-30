<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $dateFormat = \DateTime::ATOM;
    public $timestamps = false;

    protected $fillable = [
        'type',
        'ts',
        'session_id'
    ];
}

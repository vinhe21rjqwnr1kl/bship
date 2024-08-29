<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TouristDestinations extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 't_tourist_destinations';
    protected $fillable = [
        'url',
        'index',
        'status',
        'title',
        'latitude',
        'longitude',
        'limit_radius',
    ];



}

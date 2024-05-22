<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPoint extends Model
{
    use HasFactory;

    protected $table = 'log_point';
    protected $fillable = ['user_data_id', 'point', 'reason', 'created_at'];
}

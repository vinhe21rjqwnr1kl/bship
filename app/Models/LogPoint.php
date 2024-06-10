<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogPoint extends Model
{
    use HasFactory;

    protected $table = 'log_point';
    protected $fillable = ['user_data_id', 'point', 'current_point', 'new_point', 'reason', 'created_at'];

    public function user_data() : BelongsTo {
        return $this->belongsTo(UserB::class, 'user_data_id', 'id');
    }
}

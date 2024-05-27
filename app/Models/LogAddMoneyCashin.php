<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAddMoneyCashin extends Model
{
    use HasFactory;
    protected $table = 'log_add_money_cashin';
    protected $fillable = [];

    public function user_data() : BelongsTo {
        return $this->belongsTo(UserB::class, 'user_id', 'id');
    }

    public function user_driver_data() : BelongsTo {
        return $this->belongsTo(Driver::class, 'user_id', 'id');
    }
}


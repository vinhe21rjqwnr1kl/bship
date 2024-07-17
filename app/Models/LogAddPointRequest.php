<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAddPointRequest extends Model
{
    use HasFactory;
    protected $table = 'log_add_point_request';
    protected $fillable = [
        'to_user_id',
        'from_user_id',
        'reason',
        'point',
        'type',
        'create_name',
        'approved_by',
        'create_date',
        'agency_id',
        'status',
    ];

    public function from_user() : BelongsTo {
        return $this->belongsTo(UserB::class, 'from_user_id', 'id');
    }
    public function to_user() : BelongsTo {
        return $this->belongsTo(UserB::class, 'to_user_id', 'id');
    }
}

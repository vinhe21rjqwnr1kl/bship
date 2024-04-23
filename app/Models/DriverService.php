<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class DriverService extends Model
{
    use HasFactory;
    
    protected $table = 'driver_active_service';
    protected $fillable = [
        'driver_id',
        'service_detail_id',
        'active',
        'allow_service'
    ];

    /**
     * Blog belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

  


}

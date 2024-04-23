<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class Notification extends Model
{
    use HasFactory;
    
    protected $table = 'notification';
    protected $fillable = [
        'title',
        'content',
        'sender_id',
        'receiver_id',
        'is_read',
        'is_show_popup',
        'type',
        'phone',
        'create_time',
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

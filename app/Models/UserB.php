<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stevebauman\Purify\Facades\Purify;

class UserB extends Model
{
    use HasFactory;

    protected $table = 'user_data';


    /**
     * Blog belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function logPoints() : HasMany {
        return $this->hasMany(LogPoint::class, 'user_data_id', 'id');
    }

}

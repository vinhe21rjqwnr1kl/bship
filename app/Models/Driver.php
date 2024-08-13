<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stevebauman\Purify\Facades\Purify;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'user_driver_data';
    protected $fillable = [
        'name',
        'phone',
        'birthday',
        'email',
        'gplx_level',
        'gplx_number',
        'exp',
        'is_active',
        'avatar_img',
        'cmnd',
        'gplx_image',
        'agency_id',
        'money',
        'cmnd_image',
        'cmnd_image_s',
        'gplx_image',
        'gplx_image_s',
        'day_lock',
        'access_token',
        'active_token',
        'find_index',
        'car_num',
        'car_info',
        'create_time',
        'user_gsm_id',
        'car_color',
        'car_identification',
        'reason_for_block',
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

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'id');
    }


}

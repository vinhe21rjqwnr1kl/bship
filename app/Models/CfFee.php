<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class CfFee extends Model
{
    use HasFactory;
    
    protected $table = 'cf_fee';
    protected $fillable = [
        'duration_block_first',
        'fee_block_first',
        'duration_block_second',
        'fee_block_second',
        'duration_block_end',
        'fee_block_end',
        'duration_block_end_one',
        'fee_block_end_one',
        'duration_block_end_two',
        'fee_block_end_two',
        'fee_fixed',
        'fee_min',
        'fee_type',
        'service_detail_id',

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

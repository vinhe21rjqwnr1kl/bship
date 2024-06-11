<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogAddMoneyRequest extends Model
{
    use HasFactory;
    protected $table = 'log_add_money_request';
    protected $fillable = [
		'money',
		'user_id',
		'go_id',
		'user_name',
		'user_phone',
		'agency_id',
        'reason',
        'status',
        'type',
		'create_name',
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LogAddMoney extends Model
{
    use HasFactory;
    protected $table = 'log_add_money';
    protected $fillable = [
		'money',
		'user_id',
		'user_name',
		'user_phone',
		'agency_id',
        'reason',
		'create_name',
        'current_money',
		'new_money',
		'user_type',
		'type'
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}

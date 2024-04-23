<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CfServiceMain extends Model
{
    use HasFactory;
    protected $table = 'cf_service_main';

	protected $fillable = [
		'name',       
		'is_show_home',
		'is_show',
		'is_active',
		'is_ready',
		'image'
	];
	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}

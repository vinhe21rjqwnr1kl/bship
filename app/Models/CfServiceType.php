<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CfServiceType extends Model
{
    use HasFactory;
    protected $table = 'cf_services_type';
	protected $fillable = [
		'name',       
		'is_show',
		'is_active',
		'policy_content'
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}

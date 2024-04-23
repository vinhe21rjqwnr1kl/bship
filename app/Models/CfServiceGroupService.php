<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CfServiceGroupService extends Model
{
    use HasFactory;
    protected $table = 'cf_services_group_detail';
	protected $fillable = [
		'group_id',       
		'service_id'
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}

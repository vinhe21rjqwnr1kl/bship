<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CfServiceGroup extends Model
{
    use HasFactory;
    protected $table = 'cf_service_group';
	protected $fillable = [
		'name',       
		'is_active'
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}

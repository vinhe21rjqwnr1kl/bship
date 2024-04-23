<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'profile',
        'password',
        'agency_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute($value) {
        return "{$this->first_name} {$this->last_name}";
    }

    ########### Model RelationShip Functions Starts ###########

    public function blog()
    {
        return $this->hasMany(Blog::class, 'user_id', 'id');
    }

    public function page()
    {
        return $this->hasMany(Blog::class, 'user_id', 'id');
    }

    /*
    * Params-> model_class, table_name, foreign_key, local_key
    */
    public static function get_roles($user_id)
    {
       $roles =  DB::table('model_has_roles')->select('role_id')->where('model_id', "=", $user_id)->get()->toArray();

       return array_column( $roles, 'role_id' );
    }

    ########### Model RelationShip Functions End ###########


    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('Reading.date_time_format'));
    }

    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:.htaccess');
    }

}

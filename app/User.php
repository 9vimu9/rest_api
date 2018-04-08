<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    protected $dates=['deleted_at'];

    const VERIFIED_USER='1';
    const UNVERIFIED_USER='0';

    const ADMIN_USER='true';
    const REGULAR_USER='false';
    //const walata string use karanne apita mewa compare karanna wenawa ewita string tibbamma lesi

    
    protected $table='users';//we dont have sellers and buyers table but we have Seller and Buyer model so laravel assume theres is a buyers and sellers table so exception occured at migration so we define the name of table at users this value will inherit buyer and seller model (becasu both are extends user model ema nisa Buyer and Seller wala table eka bawata users path wenawa)

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    // protected $appends = array('name');

    //mutator db ekata yawanna kalin enaskamak karala db ekata dameema
    public function setNameAttribute($name)//set_colname_Attribute
    {
        $this->attributes['name']=strtolower($name);//name eka lowercase karala save kirrima
    }
    


//accessor db eken store wela thiyena data ganiddi name column eke data ganne me function eka hareaha yawalai
    public function getNameAttribute($name)//get_colname_Attribute
    {
        return ucwords($name);//name eka upper case kara ganimaa
    }




    public function isVerified()
    {
        return $this->verified==User::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->admin==User::ADMIN_USER;
    }

     public static function generateVerificationCode()
    {
        return str_random(40);
    }




}

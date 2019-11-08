<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'platforms'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    //protected $appends = ['extra_fields', 'errors'];
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules()
     {
         return [
             'first_name' => 'required|alpha',
             'last_name' => 'required|alpha',
             'email' => 'required|email',
             'password' => 'required|min:8',
             'platforms' => 'required|in:ios,windows,android,web'
         ];
     }
    
    /**
     * Get extra fields
     * @return type
     */
    public function getExtraFieldsAttribute()
    {
        return isset($this->attributes['extra_fields']) ? $this->attributes['extra_fields'] : ''; 
    }
    
    /**
     * Get errors
     * @return type
     */
    public function getErrorsAttribute()
    {
        return isset($this->attributes['errors']) ? $this->attributes['errors'] : ''; 
    }
    
}

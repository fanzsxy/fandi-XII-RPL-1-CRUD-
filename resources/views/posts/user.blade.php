<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\user as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory,Notifiable;
    
    /** 
      * fillable
      *
      * @var array
      */
    

    protected $fillable = [
        'image',
        'title',
        'content',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $cast = [
        'email_verified_at' => 'datetime'
    ];
}

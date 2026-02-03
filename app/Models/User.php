<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = ['email', 'password', 'tipeUser','photo'];

    public $timestamps = false;

    protected $hidden = ['password'];


    public function member(){
        return $this->hasOne(Member::class, 'idUser');
    }

}




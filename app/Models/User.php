<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $timestamp = true;
    protected $fillable = ['name', 'username', 'email', 'password'];
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'user');
    }
    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'user');
    }
}

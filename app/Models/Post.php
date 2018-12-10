<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'queries';
    protected $timestamp = true;
    protected $primaryKey = 'id';
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }
    public function answers()
    {
        return $this->hasMany('App\Models\Answer', 'post', 'id');
    }
}

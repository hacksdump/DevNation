<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = ['answer', 'user', 'question'];
    public function question()
    {
        return $this->belongsTo('App\Models\Post', 'question', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }
}

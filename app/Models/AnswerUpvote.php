<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerUpvote extends Model
{
    protected $table = 'answer_upvotes';
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'answer_id'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersQuestions extends Model
{
    protected $fillable = [
        'users_id', 'periods_id', 'question_id', 'correct',
    ];
}

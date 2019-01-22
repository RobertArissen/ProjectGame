<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'points', 'questionType_id', 'period_id',
    ];

    public function answers()
    {
        return $this->hasMany('App\Answer', 'question_id', 'id');
    }

    public function type()
    {
        return $this->hasOne('App\QuestionType', 'id', 'questionType_id');
    }
}

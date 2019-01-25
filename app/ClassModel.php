<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'class';

    protected $fillable = [
        'name', 'periods_id'
    ];

    public function periods()
    {
        return $this->belongsTo('App\Period');
    }
}

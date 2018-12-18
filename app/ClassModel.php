<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'class';

    public function periods()
    {
        return $this->belongsTo('App\Period');
    }
}

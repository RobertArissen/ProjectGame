<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersBuildings extends Model
{
    protected $fillable = [
        'users_id', 'periods_id', 'building_id', 'x', 'y',
    ];

    public function building()
    {
        return $this->belongsTo('App\Building');
    }
}

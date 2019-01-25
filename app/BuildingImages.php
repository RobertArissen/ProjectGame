<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingImages extends Model
{
    protected $table = 'buildings_images';

    protected $fillable = [
        'url', 'offX', 'offY'
    ];

}

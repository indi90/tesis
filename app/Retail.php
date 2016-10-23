<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retail extends Model
{
    protected $fillable = [
        'label',
        'longitude',
        'latitude',
//        'sub_district',
//        'district'
    ];

    public function histories()
    {
        return $this->belongsToMany(History::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'longitude',
        'latitude',
        'development_cost',
        'transportation_cost',
        'saving_cost',
        'track',
        'total_distance'
    ];

    public function retails()
    {
        return $this->belongsToMany(Retail::class);
    }
}

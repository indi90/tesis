<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalculateValue extends Model
{
    protected $fillable = [
        'name', 'value', 'alias'
    ];
}

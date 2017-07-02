<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialPrice extends Model
{
    protected $fillable = ['unit_id', 'quantity', 'price'];
}

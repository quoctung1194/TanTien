<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $fillable = ['name', 'original_price', 'price'];

    /**
     * Defining relationship with unitPrice model
     */
    public function unitPirce()
    {
        return $this->hasMany('App\UnitPrice');
    }

    /**
     * Defining relationship with specialPrice model
     */
    public function specialPrice()
    {
        return $this->hasMany('App\SpecialPrice');
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['drug_id', 'unit_id', 'quantity'];

    /**
     * Defining relationship with orderDetail model
     *
     */
    public function drug()
    {
        return $this->belongsTo('App\Drug');
    }

    /**
     * Defining relationship with Unit model
     */
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}

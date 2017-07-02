<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrugOrder extends Model
{
     use SoftDeletes;

    /**
     * Defining relationship with orderDetail model
     */
    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail');
    }

    /**
     * Total cash of order
     */
    public function getTotal()
    {
        return $this->orderDetails()->sum('sum');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrugOrder extends Model
{
    /**
     * Defining relationship with orderDetail model
     *
     */
    public function orderDetails()
    {
        return $this->hasMany('App\OrderDetail');
    }
}

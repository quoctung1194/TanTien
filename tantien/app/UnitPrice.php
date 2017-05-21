<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitPrice extends Model
{
    /**
     * Get the unit record associated with the unitPrice.
     */
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}

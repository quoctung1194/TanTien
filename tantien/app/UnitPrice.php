<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitPrice extends Model
{
    protected $fillable = ['unit_id', 'ref_unit_id', 'quantity'];

    /**
     * Get the unit record associated with the unitPrice.
     */
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}

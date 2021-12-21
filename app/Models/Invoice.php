<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'price', 'payment_status', 'code_created'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**********************************************************************************************
    
        ACCESSORS

    **********************************************************************************************/

    public function getPaidAttribute() {
    	if ($this->payment_status == 'Invalid') {
    		return false;
    	}
    	return true;
    }
}

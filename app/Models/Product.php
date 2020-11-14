<?php

namespace App\Models;

use Config;
use App\Models\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price', 'item_id', 'quantity',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_products';
    

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
     /**
     * Get the item associated with this item stack.
     */
    public function item() 
    {
        return $this->belongsTo('App\Models\Item\Item');
    }

}

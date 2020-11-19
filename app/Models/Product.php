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
        'price', 'item_id', 'quantity', 'is_limited', 'is_bundle', 'is_visible', 'max'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_products';

        /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'price' => 'required',
        'item_id' => 'required',
    ];
    
    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'price' => 'required',
        'item_id' => 'required',
    ];
    

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
     /**
     * Get the item associated with this item stack.
     */
    public function item() 
    {
        return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }

}

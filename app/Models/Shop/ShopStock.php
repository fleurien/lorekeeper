<?php

namespace App\Models\Shop;

use App\Models\Model;

class ShopStock extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id', 'item_id', 'currency_id', 'cost', 'use_user_bank', 'use_character_bank', 'is_limited_stock', 'quantity', 'sort', 'purchase_limit', 'is_fto', 'stock_type', 'is_visible'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_stock';

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
    /**
     * Get the item being stocked.
     */
    public function item() 
    {
        if($this->stock_type == 'Item') return $this->belongsTo('App\Models\Item\Item');
    }
    
    /**
     * Get the shop that holds this item.
     */
    public function shop() 
    {
        return $this->belongsTo('App\Models\Shop\Shop');
    }
    
    /**
     * Get the currency the item must be purchased with.
     */
    public function currency() 
    {
        return $this->belongsTo('App\Models\Currency\Currency');
    }
    
    /**********************************************************************************************
    
        OTHER FUNCTIONS

    **********************************************************************************************/

    /**
     * Scopes active stock
     */
    public function scopeActive($query)
    {
        return $query->where('is_visible', 1);
    }

    /**
     * Makes the cost an integer for display
     */
    public function getDisplayCostAttribute()
    {
        return (int)$this->cost;
    }
}

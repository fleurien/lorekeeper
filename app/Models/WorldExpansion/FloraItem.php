<?php
namespace App\Models\WorldExpansion;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\WorldExpansion\Flora;
use App\Models\Item\Item;

class FloraItem extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'flora_id', 'item_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'flora_items';
    
    public $timestamps = false;



    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/

    /**
     * Get the flora attached to this.
     */
    public function flora() 
    {
        return $this->belongsTo('App\Models\WorldExpansion\Flora', 'flora_id');
    }
    /**
     * Get the item attached to this.
     */
    public function item() 
    {
        return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }



}

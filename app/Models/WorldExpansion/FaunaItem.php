<?php
namespace App\Models\WorldExpansion;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\WorldExpansion\Fauna;
use App\Models\Item\Item;

class FaunaItem extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fauna_id', 'item_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fauna_items';
    
    public $timestamps = false;



    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/

    /**
     * Get the fauna attached to this.
     */
    public function fauna() 
    {
        return $this->belongsTo('App\Models\WorldExpansion\Fauna', 'fauna_id');
    }
    /**
     * Get the item attached to this.
     */
    public function item() 
    {
        return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }



}

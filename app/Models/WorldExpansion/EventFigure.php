<?php
namespace App\Models\WorldExpansion;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\WorldExpansion\Figure;
use App\Models\WorldExpansion\Event;
use App\Models\Item\Item;

class EventFigure extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'figure_id', 'event_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_figures';
    
    public $timestamps = false;



    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/

    /**
     * Get the figure attached to this.
     */
    public function figure() 
    {
        return $this->belongsTo('App\Models\WorldExpansion\Figure', 'figure_id');
    }
    /**
     * Get the item attached to this.
     */
    public function item() 
    {
        return $this->belongsTo('App\Models\WorldExpansion\Event', 'event_id');
    }



}

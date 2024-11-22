<?php

namespace App\Models\WorldExpansion;

use App\Models\Item\Item;
use Illuminate\Database\Eloquent\Model;

class EventFigure extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'figure_id', 'event_id',
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
    public function figure() {
        return $this->belongsTo('App\Models\WorldExpansion\Figure', 'figure_id');
    }

    /**
     * Get the item attached to this.
     */
    public function item() {
        return $this->belongsTo('App\Models\WorldExpansion\Event', 'event_id');
    }
}

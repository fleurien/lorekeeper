<?php

namespace App\Models\WorldExpansion;

use Illuminate\Database\Eloquent\Model;

class EventFaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'faction_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_factions';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the event attached to this.
     */
    public function event()
    {
        return $this->belongsTo('App\Models\WorldExpansion\Event', 'event_id');
    }

    /**
     * Get the location attached to this.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\WorldExpansion\Faction', 'faction_id');
    }
}

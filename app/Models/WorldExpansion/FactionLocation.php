<?php
namespace App\Models\WorldExpansion;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\WorldExpansion\Location;
use App\Models\WorldExpansion\Faction;

class FactionLocation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location_id', 'faction_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faction_locations';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the figure attached to this.
     */
    public function figure()
    {
        return $this->belongsTo('App\Models\WorldExpansion\Location', 'location_id');
    }
    /**
     * Get the item attached to this.
     */
    public function faction()
    {
        return $this->belongsTo('App\Models\WorldExpansion\Faction', 'faction_id');
    }

}

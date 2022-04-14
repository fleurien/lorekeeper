<?php
namespace App\Models\WorldExpansion;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\WorldExpansion\Flora;
use App\Models\WorldExpansion\Location;

class FloraLocation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'flora_id', 'location_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'flora_locations';
    
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
     * Get the location attached to this.
     */
    public function location() 
    {
        return $this->belongsTo('App\Models\WorldExpansion\Location', 'location_id');
    }



}

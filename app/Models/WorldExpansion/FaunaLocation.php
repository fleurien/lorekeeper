<?php
namespace App\Models\WorldExpansion;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\WorldExpansion\Fauna;
use App\Models\WorldExpansion\Location;

class FaunaLocation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fauna_id', 'location_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fauna_locations';
    
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
     * Get the location attached to this.
     */
    public function location() 
    {
        return $this->belongsTo('App\Models\WorldExpansion\Location', 'location_id');
    }



}

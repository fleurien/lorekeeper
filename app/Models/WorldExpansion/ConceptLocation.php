<?php

namespace App\Models\WorldExpansion;

use Illuminate\Database\Eloquent\Model;

class ConceptLocation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'concept_id', 'location_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'concept_locations';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the concept attached to this.
     */
    public function fauna()
    {
        return $this->belongsTo('App\Models\WorldExpansion\Concept', 'concept_id');
    }

    /**
     * Get the location attached to this.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\WorldExpansion\Location', 'location_id');
    }
}

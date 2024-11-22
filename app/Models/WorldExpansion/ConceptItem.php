<?php

namespace App\Models\WorldExpansion;

use App\Models\Item\Item;
use Illuminate\Database\Eloquent\Model;

class ConceptItem extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'concept_id', 'item_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'concept_items';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the fauna attached to this.
     */
    public function concept() {
        return $this->belongsTo('App\Models\WorldExpansion\Concept', 'concept_id');
    }

    /**
     * Get the item attached to this.
     */
    public function item() {
        return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }
}

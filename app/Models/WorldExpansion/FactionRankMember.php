<?php

namespace App\Models\WorldExpansion;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class FactionRankMember extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'faction_id', 'rank_id', 'member_type', 'member_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faction_rank_members';

    public $timestamps = false;

    /**********************************************************************************************

        RELATIONS
    **********************************************************************************************/

    /**
     * Get the faction this member belongs to.
     */
    public function faction() {
        return $this->belongsTo('App\Models\WorldExpansion\Faction', 'faction_id');
    }

    /**
     * Get the rank this member belongs to.
     */
    public function rank() {
        return $this->belongsTo('App\Models\WorldExpansion\FactionRank', 'rank_id');
    }

    /**
     * Get the associated figure.
     */
    public function figure() {
        return $this->belongsTo('App\Models\WorldExpansion\Figure', 'member_id');
    }

    /**
     * Get the associated user.
     */
    public function user() {
        return $this->belongsTo('App\Models\User\User', 'member_id');
    }

    /**
     * Get the associated character.
     */
    public function character() {
        return $this->belongsTo('App\Models\Character\Character', 'member_id');
    }

    /**********************************************************************************************

        ACCESSORS
    **********************************************************************************************/

    /**
     * Gets the member object depending on member type.
     *
     * @return \App\Models\Character\Character|Figure|User
     */
    public function getMemberObjectAttribute() {
        switch ($this->member_type) {
            case 'figure':
                return $this->figure;
                break;
            case 'user':
                return $this->user;
                break;
            case 'character':
                return $this->character;
                break;
        }
    }
}

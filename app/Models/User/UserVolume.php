<?php

namespace App\Models\User;

use App\Models\Model;

class UserVolume extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'volume_id', 'user_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_volumes';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**********************************************************************************************

        RELATIONS
    **********************************************************************************************/

    /**
     * Get the user who owns the volume.
     */
    public function user() {
        return $this->belongsTo('App\Models\User\User');
    }

    /**
     * Get the volume associated with this user.
     */
    public function volume() {
        return $this->belongsTo('App\Models\Volume\Volume');
    }

    /**********************************************************************************************

        ACCESSORS
    **********************************************************************************************/

    /**
     * Gets the stack's asset type for asset management.
     *
     * @return string
     */
    public function getAssetTypeAttribute() {
        return 'user_volume';
    }
}

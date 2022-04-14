<?php
namespace App\Models\WorldExpansion;

use Config;
use DB;

use Illuminate\Database\Eloquent\Model;

use App\Models\User\User;
use App\Models\Prompt\Prompt;
use App\Models\WorldExpansion\Event;
use App\Models\Item\Item;

class EventPrompt extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prompt_id', 'event_id'
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_prompts';
    
    public $timestamps = false;



    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/

    /**
     * Get the prompt attached to this.
     */
    public function prompt() 
    {
        return $this->belongsTo('App\Models\Prompt\Prompt', 'prompt_id');
    }
    /**
     * Get the item attached to this.
     */
    public function item() 
    {
        return $this->belongsTo('App\Models\WorldExpansion\Event', 'event_id');
    }



}

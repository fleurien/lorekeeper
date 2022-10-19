<?php namespace App\Services\Item;

use App\Services\Service;

use DB;
use Auth;
use Illuminate\Support\Arr;

use App\Services\InventoryManager;

use App\Models\Item\Item;
use App\Models\User\UserItem;
use App\Models\Character\Character;
use App\Models\Currency\Currency;
use App\Services\CurrencyManager;

class GiftwrapService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Box Service
    |--------------------------------------------------------------------------
    |
    | Handles the editing and usage of box type items.
    |
    */

    /**
     * Retrieves any data that should be used in the item tag editing form.
     *
     * @return array
     */
    public function getEditData()
    {
        $user = Auth::user();
        
        return [
            'items' => $user->items->filter(function ($value) {
                return $value->tags->whereIn('tag', ['giftwrapped', 'giftwrap'])->count() === 0;
            })->pluck('name', 'id')->toArray(),
            // 'characters' => $user->characters->pluck('name', 'id')->toArray(),
            'myos' => $user->myoSlots->pluck('name', 'id')->toArray(),
            'currencies' => $user->getCurrencySelect(),
            'giftwrappeds' => Item::whereHas('tags', function($q) {
                return $q->where('tag', 'giftwrapped');
            })->pluck('name', 'id')
        ];
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param  object  $tag
     * @return mixed
     */
    public function getTagData($tag)
    {
        return $tag->data;
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param  object  $tag
     * @param  array   $data
     * @return bool
     */
    public function updateData($tag, $data)
    {
        DB::beginTransaction();

        try {
            $tag->data = $data['wrap_id'];
            $tag->save();
            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }


    /**
     * Acts upon the item when used from the inventory.
     *
     * @param  \App\Models\User\UserItem  $stacks
     * @param  \App\Models\User\User      $user
     * @param  array                      $data
     * @return bool
     */
    public function act($stacks, $user, $data)
    {
        DB::beginTransaction();

        try {
            foreach($stacks as $key=>$stack) {
                if($stack->user_id != $user->id) throw new \Exception("This item does not belong to you.");
                $inventoryManager = new InventoryManager;
                // Try to delete the box item. If successful, we can start distributing rewards.
                if($inventoryManager->debitStack($stack->user, 'Box Opened', ['data' => ''], $stack, $data['quantities'][$key])) {
                    $user = Auth::user();
                    $item = Item::where('id', $stack->item->tag('giftwrap')->data)->first();
                        
                    if($data['wrap_type'] === 'Item') {
                        $wrapStack = UserItem::where([['user_id', $user->id], ['item_id', $data['wrap_id']], ['count', '>', 0]])->first();
                        // Try to delete the to be wrapped item
                        if($inventoryManager->debitStack($user, 'Wrapped Up', ['data' => ''], $wrapStack, $data['quantities'][$key])) {
                            if($inventoryManager->creditItem(null, $user, 'Wrapped Item', Arr::only($data, ['wrap_type', 'wrap_id']) + ['data' => '', 'notes' => isset($data['display_contents']) ? 'Contains '.$wrapStack->item->displayName : ''], $item, 1)){
                                flash($wrapStack->item->name.' successfully wrapped!');
                            } else { throw new \Exception("Failed to create wrapped item"); }
                        } else { throw new \Exception("Failed to wrap item"); }
                    } else if($data['wrap_type'] === 'Character' || $data['wrap_type'] === 'MYO') {
                        $myo = Character::where([['user_id', $user->id], ['id', $data['wrap_id']]])->first();
                        if(!isset($data['display_contents'])) {
                            $myo->is_visible = 0;
                            $myo->save();
                        }
                        if($inventoryManager->creditItem(null, $user, 'Wrapped Item', Arr::only($data, ['wrap_type', 'wrap_id']) + ['data' => '', 'notes' => isset($data['display_contents']) ? 'Contains '.$myo->displayName : ''], $item, 1)){
                            flash($myo->name.' successfully wrapped!');
                        } else { throw new \Exception("Failed to create wrapped item"); }
                    } else if($data['wrap_type'] === 'Currency') {
                        $currency = Currency::where('id', $data['wrap_id'])->first();
                        if((new CurrencyManager)->debitCurrency($user, null, 'Wrapped Currency', null, $currency, $data['wrap_count'])) {
                            if($inventoryManager->creditItem(null, $user, 'Wrapped Item', Arr::only($data, ['wrap_type', 'wrap_id', 'wrap_count']) + ['data' => '', 'notes' => isset($data['display_contents']) ? 'Contains '.$currency->display($data['wrap_count']) : ''], $item, 1)){
                                flash($currency->display($data['wrap_count']).' successfully wrapped!');
                            } else { throw new \Exception("Failed to create wrapped item"); }
                        } else { throw new \Exception("Failed to wrap item"); }
                    }         
                } else { throw new \Exception("Failed to remove wrapping"); }
            }
            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
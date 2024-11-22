<?php

namespace App\Services\Item;

use App\Models\Character\Character;
use App\Models\Currency\Currency;
use App\Models\Item\Item;
use App\Services\CharacterManager;
use App\Services\CurrencyManager;
use App\Services\InventoryManager;
use App\Services\Service;
use DB;
use Illuminate\Support\Arr;

class GiftwrappedService extends Service {
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
    public function getEditData() {
        return [
            // 'characterCurrencies' => Currency::where('is_character_owned', 1)->orderBy('sort_character', 'DESC')->pluck('name', 'id'),
            // 'items' => Item::orderBy('name')->pluck('name', 'id'),
            // 'currencies' => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            // 'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
            // 'raffles' => Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id'),
        ];
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param object $tag
     *
     * @return mixed
     */
    public function getTagData($tag) {
        return $tag->data;
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param object $tag
     * @param array  $data
     *
     * @return bool
     */
    public function updateData($tag, $data) {
        DB::beginTransaction();

        try {
            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Acts upon the item when used from the inventory.
     *
     * @param \App\Models\User\UserItem $stacks
     * @param \App\Models\User\User     $user
     * @param array                     $data
     *
     * @return bool
     */
    public function act($stacks, $user, $data) {
        DB::beginTransaction();

        try {
            foreach ($stacks as $key => $stack) {
                if ($stack->user_id != $user->id) {
                    throw new \Exception('This item does not belong to you.');
                }
                $inventoryManager = new InventoryManager;
                // Try to delete the box item. If successful, we can distribute the wrapped item.
                if ($inventoryManager->debitStack($stack->user, 'Box Opened', ['data' => ''], $stack, $data['quantities'][$key])) {
                    for ($i = 1; $i <= $data['quantities'][$key]; $i++) {
                        if ($stack->data['wrap_type'] === 'Item') {
                            $item = Item::where('id', $stack->data['wrap_id'])->first();
                            if ($inventoryManager->creditItem(null, $user, 'Unwrapped Item', Arr::only($data, ['wrap_type', 'wrap_id']) + ['data' => 'Received from Wrapped Box'], $item, 1)) {
                                flash($item->name.' received from box!');
                            } else {
                                throw new \Exception('Failed to create wrapped item');
                            }
                        } elseif ($stack->data['wrap_type'] === 'Character' || $stack->data['wrap_type'] === 'MYO') {
                            $myo = Character::where('id', $stack->data['wrap_id'])->first();
                            $myo->is_visible = 1;
                            $myo->save();

                            if ((new CharacterManager)->adminTransfer(['recipient_id' => $user->id, 'reason' => 'Unwrapped from Box'], $myo, $user)) {
                                flash($myo->name.' received from box!');
                            } else {
                                throw new \Exception('Failed to transfer wrapped item');
                            }
                        } elseif ($stack->data['wrap_type'] === 'Currency') {
                            $currency = Currency::where('id', $stack->data['wrap_id'])->first();
                            if ((new CurrencyManager)->creditCurrency(null, $user, 'Unwrapped Currency', null, $currency, $stack->data['wrap_count'])) {
                                flash($currency->display($stack->data['wrap_count']).' received from box!');
                            } else {
                                throw new \Exception('Failed to wrap item');
                            }
                        }
                    }
                } else {
                    throw new \Exception('Failed to remove wrapper');
                }
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }
}

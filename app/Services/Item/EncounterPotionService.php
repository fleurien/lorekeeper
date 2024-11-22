<?php

namespace App\Services\Item;

use App\Services\InventoryManager;
use App\Services\Service;
use DB;

class EncounterPotionService extends Service {
    /*
    |--------------------------------------------------------------------------
    | Potion Service
    |--------------------------------------------------------------------------
    |
    | Handles the editing and usage of potion type items.
    |
    */

    /**
     * Retrieves any data that should be used in the item tag editing form.
     *
     * @return array
     */
    public function getEditData() {
        return [
        ];
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format for edits.
     *
     * @param string $tag
     *
     * @return mixed
     */
    public function getTagData($tag) {
        $potionData['value'] = $tag->data['value'] ?? 0;

        return $potionData;
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format for DB storage.
     *
     * @param string $tag
     * @param array  $data
     *
     * @return bool
     */
    public function updateData($tag, $data) {
        $potionData['value'] = $data['value'] ?? 0;

        DB::beginTransaction();

        try {
            $tag->update(['data' => json_encode($potionData)]);

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
            foreach ($stacks as $key=> $stack) {
                // We don't want to let anyone who isn't the owner of the slot to use it,
                // so do some validation...
                if ($stack->user_id != $user->id) {
                    throw new \Exception('This item does not belong to you.');
                }

                // Next, try to delete the tag item. If successful, we can start applying potion effects.
                if ((new InventoryManager)->debitStack($stack->user, 'Encounter Potion Used', ['data' => ''], $stack, $data['quantities'][$key])) {
                    for ($q = 0; $q < $data['quantities'][$key]; $q++) {
                        $quantity = $stack->item->tag($data['tag'])->getData()['value'];

                        $user->settings->encounter_energy += $quantity;
                        $user->settings->save();
                    }
                }
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }
}

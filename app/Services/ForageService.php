<?php namespace App\Services;

use App\Services\Service;

use DB;
use Config;

use App\Models\Foraging\Forage;
use App\Models\Foraging\ForageReward;
use App\Models\Prompt\PromptReward;

class ForageService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Loot Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of loot tables.
    |
    */

    /**
     * Creates a loot table.
     *
     * @param  array  $data
     * @return bool|\App\Models\Loot\Forage
     */
    public function createForage($data)
    {
        DB::beginTransaction();

        try {
            
            // More specific validation
            foreach($data['rewardable_type'] as $key => $type)
            {
                if(!$type) throw new \Exception("Loot type is required.");
                if(!$data['rewardable_id'][$key]) throw new \Exception("Reward is required.");
                if(!$data['quantity'][$key] || $data['quantity'][$key] < 1) throw new \Exception("Quantity is required and must be an integer greater than 0.");
                if(!$data['weight'][$key] || $data['weight'][$key] < 1) throw new \Exception("Weight is required and must be an integer greater than 0.");
            }

            if(!isset($data['is_active'])) $data['is_active'] = 0;

            $table = Forage::create(array_only($data, ['name', 'display_name', 'is_active']));

            $this->populateForage($table, array_only($data, ['rewardable_type', 'rewardable_id', 'quantity', 'weight']));

            return $this->commitReturn($table);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a loot table.
     *
     * @param  \App\Models\Loot\Forage  $table
     * @param  array                       $data 
     * @return bool|\App\Models\Loot\Forage
     */
    public function updateForage($table, $data)
    {
        DB::beginTransaction();

        try {
            
            // More specific validation
            foreach($data['rewardable_type'] as $key => $type)
            {
                if(!$type) throw new \Exception("Loot type is required.");
                if(!$data['rewardable_id'][$key]) throw new \Exception("Reward is required.");
                if(!$data['quantity'][$key] || $data['quantity'][$key] < 1) throw new \Exception("Quantity is required and must be an integer greater than 0.");
                if(!$data['weight'][$key] || $data['weight'][$key] < 1) throw new \Exception("Weight is required and must be an integer greater than 0.");
            }

            if(!isset($data['is_active'])) $data['is_active'] = 0;

            $table->update(array_only($data, ['name', 'display_name', 'is_active']));

            $this->populateForage($table, array_only($data, ['rewardable_type', 'rewardable_id', 'quantity', 'weight']));

            return $this->commitReturn($table);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Handles the creation of loot for a loot table.
     *
     * @param  \App\Models\Loot\Forage  $table
     * @param  array                       $data 
     */
    private function populateForage($table, $data)
    {
        // Clear the old loot...
        $table->loot()->delete();

        foreach($data['rewardable_type'] as $key => $type)
        {
            ForageReward::create([
                'forage_id'   => $table->id,
                'rewardable_type' => $type,
                'rewardable_id'   => $data['rewardable_id'][$key],
                'quantity'        => $data['quantity'][$key],
                'weight'          => $data['weight'][$key]
            ]);
        }
    }

    /**
     * Deletes a loot table.
     *
     * @param  \App\Models\Loot\Forage  $table
     * @return bool
     */
    public function deleteForage($table)
    {
        DB::beginTransaction();

        try {
            // Check first if the table is currently in use
            // - Prompts
            // - Box rewards (unfortunately this can't be checked easily)

            $table->loot()->delete();
            $table->delete();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
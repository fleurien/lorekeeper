<?php

namespace App\Services\Stat;

use App\Models\Stat\Stat;
use App\Services\Service;
use DB;

class StatService extends Service {
    /**
     * Creates a new stat.
     *
     * @param mixed $data
     */
    public function createStat($data) {
        DB::beginTransaction();

        try {
            if (!isset($data['name'])) {
                throw new \Exception('Please name the stat');
            }
            if (!isset($data['base'])) {
                throw new \Exception('Please set a default.');
            }
            if (!isset($data['abbreviation'])) {
                throw new \Exception('Please add an abbreviation.');
            }

            $stat = Stat::create($data);

            return $this->commitReturn($stat);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Updates a stat.
     *
     * @param mixed $stat
     * @param mixed $data
     */
    public function updateStat($stat, $data) {
        DB::beginTransaction();

        try {
            $stat->update($data);

            return $this->commitReturn($stat);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Deletes a stat.
     *
     * @param mixed $stat
     */
    public function deleteStat($stat) {
        DB::beginTransaction();

        try {
            // Check first if the stat is currently owned or if some other site feature uses it
            if (DB::table('character_stats')->where('stat_id', $stat->id)->exists()) {
                throw new \Exception('A character currently has this stat.');
            }

            $stat->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }
}

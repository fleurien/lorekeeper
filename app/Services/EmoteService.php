<?php

namespace App\Services;

use App\Models\Emote;
use DB;

class EmoteService extends Service {
    /*
    |--------------------------------------------------------------------------
    | Emote Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of emote categories and emotes.
    |
    */

    /**********************************************************************************************
        EmoteS
    **********************************************************************************************/

    /**
     * Creates a new emote.
     *
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return bool|Emote
     */
    public function createEmote($data, $user) {
        DB::beginTransaction();

        try {
            $image = null;
            if (isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            } else {
                $data['has_image'] = 0;
            }

            $data['is_active'] = isset($data['is_active']);

            $emote = Emote::create($data);

            if ($image) {
                $this->handleImage($image, $emote->imagePath, $emote->imageFileName);
            }

            return $this->commitReturn($emote);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Updates an emote.
     *
     * @param Emote                 $emote
     * @param array                 $data
     * @param \App\Models\User\User $user
     *
     * @return bool|Emote
     */
    public function updateEmote($emote, $data, $user) {
        DB::beginTransaction();

        try {
            // More specific validation
            if (Emote::where('name', $data['name'])->where('id', '!=', $emote->id)->exists()) {
                throw new \Exception('The name has already been taken.');
            }

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $image = $data['image'];
                unset($data['image']);
            }
            $data['is_active'] = isset($data['is_active']);

            $emote->update($data);

            if ($emote) {
                $this->handleImage($image, $emote->imagePath, $emote->imageFileName);
            }

            return $this->commitReturn($emote);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Deletes an emote.
     *
     * @param Emote\Emote $emote
     *
     * @return bool
     */
    public function deleteEmote($emote) {
        DB::beginTransaction();

        try {
            if (file_exists($emote->imagePath.'/'.$emote->imageFileName)) {
                $this->deleteImage($emote->imagePath, $emote->imageFileName);
            }
            $emote->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }
}

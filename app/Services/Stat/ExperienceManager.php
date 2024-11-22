<?php

namespace App\Services\Stat;

use App\Models\Character\Character;
use App\Models\Level\CharacterLevel;
use App\Models\Level\UserLevel;
use App\Models\User\User;
use App\Services\Service;
use Carbon\Carbon;
use DB;
use Notifications;

class ExperienceManager extends Service {
    /**
     * Grants EXP to multiple users.
     *
     * @param array $data
     * @param User  $staff
     *
     * @return bool
     */
    public function grantExp($data, $staff) {
        DB::beginTransaction();

        try {
            // Process names
            $users = User::find($data['names']);
            if (count($users) != count($data['names'])) {
                throw new \Exception('An invalid user was selected.');
            }

            foreach ($users as $user) {
                if ($this->creditExp($staff, $user, 'Staff Grant', $data['data'], $data['quantity'])) {
                    Notifications::create('EXP_GRANT', $user, [
                        'quantity'    => $data['quantity'],
                        'sender_url'  => $staff->url,
                        'sender_name' => $staff->name,
                    ]);
                } else {
                    throw new \Exception('Failed to credit exp to '.$user->name.'.');
                }
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Grants EXP to one user.
     *
     * @param mixed $sender
     * @param mixed $recipient
     * @param mixed $type
     * @param mixed $data
     * @param mixed $quantity
     */
    public function creditExp($sender, $recipient, $type, $data, $quantity) {
        DB::beginTransaction();

        try {
            // for user
            if ($recipient->logType == 'User') {
                $recipient_stack = UserLevel::where('user_id', '=', $recipient->id)->first();

                if (!$recipient_stack) {
                    $recipient_stack = UserLevel::create(['user_id' => $recipient->id]);
                }
                $recipient_stack->current_exp += $quantity;
                $recipient_stack->save();
            }
            // for character
            else {
                $recipient_stack = CharacterLevel::where('character_id', $recipient->id)->first();

                if (!$recipient_stack) {
                    $recipient_stack = CharacterLevel::create(['character_id' => $recipient->id]);
                }
                $recipient_stack->current_exp += $quantity;
                $recipient_stack->save();
            }
            if ($type && !$this->createLog($sender ? $sender->id : null, $sender ? $sender->logType : null, $recipient ? $recipient->id : null, $recipient ? $recipient->logType : null, $type, $data, $quantity)) {
                throw new \Exception('Failed to create log.');
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Debits exp from a user or character.
     *
     * @param mixed $owner
     * @param mixed $type
     * @param mixed $data
     * @param mixed $level
     * @param mixed $quantity
     */
    public function debitExp($owner, $type, $data, $level, $quantity) {
        DB::beginTransaction();

        try {
            $level->current_exp -= $quantity;
            $level->save();

            if ($type && !$this->createLog($owner ? $owner->id : null, $owner ? $owner->logType : null, null, null, $type, $data, -$quantity)) {
                throw new \Exception('Failed to create log.');
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * Creates a log.
     *
     * @param mixed $senderId
     * @param mixed $senderType
     * @param mixed $recipientId
     * @param mixed $recipientType
     * @param mixed $type
     * @param mixed $data
     * @param mixed $quantity
     */
    public function createLog($senderId, $senderType, $recipientId, $recipientType, $type, $data, $quantity) {
        return DB::table('exp_log')->insert(
            [
                'sender_id'      => $senderId,
                'sender_type'    => $senderType,
                'recipient_id'   => $recipientId,
                'recipient_type' => $recipientType,
                'log'            => $type.($data ? ' ('.$data.')' : ''),
                'log_type'       => $type,
                'data'           => $data,
                'quantity'       => $quantity,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]
        );
    }
}

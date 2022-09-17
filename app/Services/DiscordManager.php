<?php

namespace App\Services;

use App\Models\Discord\DiscordReward;
use App\Models\User\UserAlias;
use App\Models\User\UserDiscordLevel;
use Config;
use Intervention\Image\Facades\Image;
use Settings;

class DiscordManager extends Service
{
    /**
     * Handles webhook messages.
     *
     * @param mixed      $content
     * @param mixed      $title
     * @param mixed      $embed_content
     * @param mixed|null $author
     * @param mixed|null $url
     * @param mixed|null $fields
     */
    public function handleWebhook($content, $title, $embed_content, $author = null, $url = null, $fields = null)
    {
        $webhook = env('DISCORD_WEBHOOK_URL');
        if ($webhook) {
            // format data
            if ($author) {
                $author_data = [
                    'name'     => $author->name,
                    'url'      => $author->url,
                    'icon_url' => url('/images/avatars/'.$author->avatar),
                ];
            }
            $description = $url ? 'View [Here]('.$url.')' : '_ _';
            $data = [];
            $data['username'] = Config::get('lorekeeper.settings.site_name', 'Lorekeeper');
            $data['avatar_url'] = url('images/favicon.ico');
            $data['content'] = $content;
            $data['embeds'] = [[
                'color'       => 6208428,
                'author'      => $author_data ?? null,
                'title'       => $title,
                'description' => $description,
            ]];
            if ($fields) {
                $data['embeds'][0]['fields'] = [$fields];
            }

            // send post to webhook, with $data as json payload
            $ch = curl_init($webhook);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // get response
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response != '') {
                return ['error' => $response];
            }

            return true;
        }
    }

    /**
     * Generate a rank card for a user on request.
     *
     * @param \Discord\Parts\Interactions\Interaction $interaction
     *
     * @return string
     */
    public function showUserInfo($interaction)
    {
        // Provided message author, fetch user information
        if (UserAlias::where('extra_data', $interaction->user->id)->exists()) {
            $user = UserAlias::where('extra_data', $interaction->user->id)->first()->user;
        } else {
            return false;
        }

        // Fetch level information
        $level = UserDiscordLevel::where('user_id', $user->id)->first();
        if (!$level) {
            // Or create it, if necessary
            $this->giveExp($interaction->user->id, $interaction->timestamp);
            $level = UserDiscordLevel::where('user_id', $user->id)->first();
        }

        // Fetch config values for convenience
        $config = [
            'bg'      => config('lorekeeper.discord_bot.rank_cards.background_color'),
            'accent'  => config('lorekeeper.discord_bot.rank_cards.accent_color'),
            'exp'     => config('lorekeeper.discord_bot.rank_cards.exp_bar'),
            'font'    => public_path(config('lorekeeper.discord_bot.rank_cards.font_file')),
            'text'    => config('lorekeeper.discord_bot.rank_cards.text_color'),
            'expText' => config('lorekeeper.discord_bot.rank_cards.exp_text') ?? config('lorekeeper.discord_bot.rank_cards.text_color'),
            'opacity' => config('lorekeeper.discord_bot.rank_cards.accent_opacity'),
            'logo'    => config('lorekeeper.discord_bot.rank_cards.logo_insert') ?? null,
        ];

        // Assemble avatar using circular mask
        $avatar = Image::canvas(150, 150, $config['accent'])
            ->insert(public_path('images/avatars/'.$user->avatar), 'center')
            ->mask(public_path('images/cards/assets/avatar_mask.png'));

        // Assemble a small inset to sit behind the text
        $inset = Image::canvas(365, 90, $config['accent'])
            ->opacity($config['opacity'])
            ->mask(public_path('images/cards/assets/rank_card_mask.png'));

        // Assemble EXP bar
        $requiredExp = 5 * (pow($level->level, 2)) + (50 * $level->level) + 100;
        $progress = Image::canvas(365, 20, $config['accent'])
            ->opacity($config['opacity'])
            ->rectangle(0, 0, ($level->exp / $requiredExp) * 365, 20, function ($draw) use ($config) {
                // Fill a portion of the bar relative to the user's
                // current discord EXP
                $draw->background($config['exp']);
            })
            ->mask(public_path('images/cards/assets/rank_card_mask.png'));

        // Assemble rank card
        $card = Image::canvas(600, 200, $config['bg'])
            ->insert(public_path('images/rank_card_background.png'));

        if ($config['logo']) {
            $card
                ->insert(public_path($config['logo']), 'bottom-right');
        }

        $card
            ->mask(public_path('images/cards/assets/rank_card_mask.png'))
            ->insert($inset, 'bottom-right', 48, 75)
            ->insert($progress, 'bottom-right', 48, 45)
            ->insert($avatar, 'left', 20)
            ->text($user->name, 200, 85, function ($font) use ($config) {
                // Username
                $font->file($config['font']);
                $font->color($config['text']);
                $font->align('left');
                $font->size(40);
            })
            ->text($user->rank->name, 201, 105, function ($font) use ($user, $config) {
                // User rank
                $font->file($config['font']);
                $font->color($user->rank->color ?? $config['text']);
                $font->align('left');
                $font->size(22);
            })
            ->text('#'.$level->relativeRank($user), 540, 80, function ($font) use ($config) {
                // Relative discord rank
                $font->file($config['font']);
                $font->color($config['text']);
                $font->align('right');
                $font->size(40);
            })
            ->text('Level '.$level->level, 540, 105, function ($font) use ($config) {
                // Discord level
                $font->file($config['font']);
                $font->color($config['text']);
                $font->align('right');
                $font->size(22);
            })
            ->text($level->exp.'/'.$requiredExp.' EXP', 550, 170, function ($font) use ($config) {
                // Exp info
                $font->file($config['font']);
                $font->color($config['expText']);
                $font->align('right');
                $font->size(15);
            });

        // Set dir and filename
        $dir = public_path('images/cards');
        $filename = randomString(15).'.png';

        // Save the card itself and return the filename
        $card->save($dir.'/'.$filename);

        return $filename;
    }

    /**
     * Check and distribute rewards.
     *
     * @param mixed $id
     */
    public function checkRewards($id)
    {
        try {
            if (UserAlias::where('extra_data', $id)->exists()) {
                $user = UserAlias::where('extra_data', $id)->first()->user;
            } else {
                return;
            }
            $level = UserDiscordLevel::where('user_id', $user->id)->first();

            $rewards = DiscordReward::where('level', $level->level)->get();

            $data = [];
            // check if there's a role to be given to the user
            $role = $rewards->where('role_reward_id', '!=', null)->first();
            if ($role) {
                $data['role'] = $role->role_reward_id;
            }

            // on-site reward distribution
            if ($rewards) {
                $assets = createAssetsArray();
                $data['count'] = 0;

                foreach ($rewards as $reward) {
                    $raw_types = json_decode($reward->loot, true);
                    //
                    foreach ($raw_types as $type=>$raws) {
                        $model = getAssetModelString($type);
                        if ($model) {
                            foreach ($raws as $key=>$raw) {
                                $assets[$type][] = [
                                    'asset'    => $model::find($key),
                                    'quantity' => $raw['quantity'],
                                ];

                                $data['count'] += 1;
                            }
                        }
                    }
                }
            }

            // Logging data
            $logType = 'Discord Level Up';
            $logData = [
                'data' => 'Received rewards for levelling up to level '.$level->level.'.',
            ];

            // Distribute user rewards
            if (!$assets = fillUserAssets($assets, null, $user, $logType, $logData)) {
                throw new \Exception('Failed to distribute rewards to user.');
            }

            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Add EXP to a user.
     *
     * @param int id
     * @param Carbon $timestamp
     * @param mixed  $id
     */
    public function giveExp($id, $timestamp)
    {
        try {
            if (UserAlias::where('extra_data', $id)->exists()) {
                $user = UserAlias::where('extra_data', $id)->first()->user;
            } else {
                return;
            }
            $level = UserDiscordLevel::where('user_id', $user->id)->first();

            // set constant for max exp you can gain.
            // multiplier can increase this
            $exp = 20;
            $multiplier = Settings::get('discord_exp_multiplier') ?? 1;

            if (!$level) {
                $level = UserDiscordLevel::create([
                    'user_id'         => $user->id,
                    'level'           => 0,
                    'exp'             => 0,
                    'last_message_at' => $timestamp,
                ]);
                // since they've never had a message before, we can just add exp straight away
                $level->exp += mt_rand($exp / 2, $exp) * $multiplier;
                $level->save();
            // formula: 5 * (lvl ^ 2) + (50 * lvl) + 100 - xp
                // lvl is current level
                // xp is how much XP already have towards the next level.
            } else {
                // check if it's been a minute since the last message
                if (!$level->last_message_at || 1 <= $timestamp->diffInMinutes($level->last_message_at)) {
                    $level->exp += mt_rand($exp / 2, $exp) * $multiplier;
                    $level->last_message_at = $timestamp;
                    $level->save();
                }
            }

            $requiredExp = 5 * (pow($level->level, 2)) + (50 * $level->level) + 100 - $level->exp;
            if ($requiredExp <= 0) {
                $level->level++;
                $level->exp = 0;
                $level->save();

                return [
                    'action' => 'Level',
                    'level'  => $level->level,
                    'user'   => $user,
                ];
            }
            // if nothing happened just continue as normal
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discord\DiscordReward;
use App\Services\DiscordService;
use Auth;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    /*****************************************************************************
     * REWARDS SECTION
     *****************************************************************************/

    /**
     * Gets the reward index page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDiscordRewardIndex(Request $request)
    {
        return view('admin.discord.reward_index', [
            'rewards' => DiscordReward::all(),
        ]);
    }

    /**
     * Gets create reward page.
     */
    public function getCreateReward()
    {
        return view('admin.discord.create_edit_reward', [
            'reward' => new DiscordReward(),
        ]);
    }

    /**
     * Gets edit reward page.
     *
     * @param mixed $id
     */
    public function getEditReward($id)
    {
        return view('admin.discord.create_edit_reward', [
            'reward' => DiscordReward::findOrFail($id),
        ]);
    }

    /**
     * Creates or updates a reward.
     *
     * @param mixed|null $id
     */
    public function postCreateEditReward(Request $request, DiscordService $service, $id = null)
    {
        $id ? $request->validate(DiscordReward::$updateRules) : $request->validate(DiscordReward::$createRules);
        $data = $request->only([
            'level', 'rewardable_type', 'rewardable_id', 'quantity', 'role_reward_id',
        ]);
        if ($id && $service->updateReward(DiscordReward::find($id), $data, Auth::user())) {
            flash('Reward updated successfully.')->success();
        } elseif (!$id && $reward = $service->createReward($data, Auth::user())) {
            flash('Reward created successfully.')->success();

            return redirect()->to('admin/discord/rewards/edit/'.$reward->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /*****************************************************************************
     * LEVEL SECTION
     *****************************************************************************/

    /**
     * gets level index page.
     */
    public function getDiscordLevelIndex()
    {
        return 'coming soon';
    }
}

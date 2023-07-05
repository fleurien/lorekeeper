<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use Log;
use App\Models\Emote;

use App\Services\EmoteService;
use App\Http\Controllers\Controller;

class EmoteController extends Controller
{
    /**
     * Get index
     */
    public function getEmoteIndex()
    {
        return view('admin.emotes.emotes', [
            'emotes' => Emote::all()
        ]);
    }

    /**
     * Shows the create emote page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateEmote()
    {
        return view('admin.emotes.create_edit_emote', [
            'emote' => new Emote,
        ]);
    }

    /**
     * Shows the edit emote page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditEmote($id)
    {
        return view('admin.emotes.create_edit_emote', [
            'emote' => Emote::findOrFail($id),
        ]);
    }

    /**
     * Creates or edits an emote.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\EmoteService  $service
     * @param  int|null                  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditEmote(Request $request, EmoteService $service, $id = null)
    {
        $id ? $request->validate(Emote::$updateRules) : $request->validate(Emote::$createRules);
        $data = $request->only([
            'name','image', 'is_active'
        ]);
        if($id && $service->updateEmote(Emote::find($id), $data, Auth::user())) {
            flash('Emote updated successfully.')->success();
        }
        else if (!$id && $emote = $service->createEmote($data, Auth::user())) {
            flash('Emote created successfully.')->success();
            return redirect()->to('admin/emotes/edit/'.$emote->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Deletes a emote.
     */
    public function getDeleteEmote($id)
    {
        $emote = Emote::findOrFail($id);
        return view('admin.emotes._delete_emote', [
            'emote' => $emote,
        ]);
    }

    /**
     * Deletes a emote.
     */
    public function postDeleteEmote(Request $request, EmoteService $service, $id)
    {
        if($service->deleteEmote(Emote::find($id))) {
            flash('Emote deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/emotes');
    }

}
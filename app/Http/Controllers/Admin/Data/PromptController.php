<?php

namespace App\Http\Controllers\Admin\Data;

use Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Award\Award;
use App\Models\Claymore\Gear;
use App\Models\Claymore\Weapon;
use App\Models\Currency\Currency;
use App\Models\Item\Item;
use App\Models\Loot\LootTable;
use App\Models\Pet\Pet;
use App\Models\Prompt\Prompt;
use App\Models\Prompt\PromptCategory;
use App\Models\Raffle\Raffle;
use App\Models\Recipe\Recipe;
use App\Models\Skill\Skill;

use App\Services\PromptService;

class PromptController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin / Prompt Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of prompt categories and prompts.
    |
    */

    /**
     * Shows the prompt category index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('admin.prompts.prompt_categories', [
            'categories' => PromptCategory::orderBy('sort', 'DESC')->get(),
        ]);
    }

    /**
     * Shows the create prompt category page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreatePromptCategory()
    {
        return view('admin.prompts.create_edit_prompt_category', [
            'category' => new PromptCategory,
        ]);
    }

    /**
     * Shows the edit prompt category page.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditPromptCategory($id)
    {
        $category = PromptCategory::find($id);
        if (!$category) {
            abort(404);
        }

        return view('admin.prompts.create_edit_prompt_category', [
            'category' => $category,
        ]);
    }

    /**
     * Creates or edits a prompt category.
     *
     * @param App\Services\PromptService $service
     * @param int|null                   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditPromptCategory(Request $request, PromptService $service, $id = null)
    {
        $id ? $request->validate(PromptCategory::$updateRules) : $request->validate(PromptCategory::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image',
        ]);
        if ($id && $service->updatePromptCategory(PromptCategory::find($id), $data, Auth::user())) {
            flash('Category updated successfully.')->success();
        } elseif (!$id && $category = $service->createPromptCategory($data, Auth::user())) {
            flash('Category created successfully.')->success();

            return redirect()->to('admin/data/prompt-categories/edit/'.$category->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Gets the prompt category deletion modal.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeletePromptCategory($id)
    {
        $category = PromptCategory::find($id);

        return view('admin.prompts._delete_prompt_category', [
            'category' => $category,
        ]);
    }

    /**
     * Deletes a prompt category.
     *
     * @param App\Services\PromptService $service
     * @param int                        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeletePromptCategory(Request $request, PromptService $service, $id)
    {
        if ($id && $service->deletePromptCategory(PromptCategory::find($id))) {
            flash('Category deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->to('admin/data/prompt-categories');
    }

    /**
     * Sorts prompt categories.
     *
     * @param App\Services\PromptService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortPromptCategory(Request $request, PromptService $service)
    {
        if ($service->sortPromptCategory($request->get('sort'))) {
            flash('Category order updated successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**********************************************************************************************

        PROMPTS

    **********************************************************************************************/

    /**
     * Shows the prompt category index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPromptIndex(Request $request)
    {
        $query = Prompt::query();
        $data = $request->only(['prompt_category_id', 'name']);
        if (isset($data['prompt_category_id']) && $data['prompt_category_id'] != 'none') {
            $query->where('prompt_category_id', $data['prompt_category_id']);
        }
        if (isset($data['name'])) {
            $query->where('name', 'LIKE', '%'.$data['name'].'%');
        }

        return view('admin.prompts.prompts', [
            'prompts'    => $query->paginate(20)->appends($request->query()),
            'categories' => ['none' => 'Any Category'] + PromptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
        ]);
    }

    /**
     * Shows the create prompt page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreatePrompt()
    {
        return view('admin.prompts.create_edit_prompt', [
            'prompt'     => new Prompt,
            'categories' => ['none' => 'No category'] + PromptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'items'      => Item::orderBy('name')->pluck('name', 'id'),
            'awards'     => Award::orderBy('name')->pluck('name', 'id'),
            'currencies' => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'pets' => Pet::orderBy('name')->pluck('name', 'id'),
            'gears' => Gear::orderBy('name')->pluck('name', 'id'),
            'weapons' => Weapon::orderBy('name')->pluck('name', 'id'),
            'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
            'raffles' => Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id'),
            'recipes'=> Recipe::orderBy('name')->pluck('name', 'id'),
            'skills' => Skill::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Shows the edit prompt page.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditPrompt($id)
    {
        $prompt = Prompt::find($id);
        if (!$prompt) {
            abort(404);
        }

        return view('admin.prompts.create_edit_prompt', [
            'prompt'     => $prompt,
            'categories' => ['none' => 'No category'] + PromptCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'items'      => Item::orderBy('name')->pluck('name', 'id'),
            'awards'     => Award::orderBy('name')->pluck('name', 'id'),
            'currencies' => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'pets' => Pet::orderBy('name')->pluck('name', 'id'),
            'gears' => Gear::orderBy('name')->pluck('name', 'id'),
            'weapons' => Weapon::orderBy('name')->pluck('name', 'id'),
            'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
            'raffles' => Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id'),
            'recipes'=> Recipe::orderBy('name')->pluck('name', 'id'),
            'skills' => Skill::pluck('name', 'id')->toArray()
        ]);
    }

    /**
     * Creates or edits a prompt.
     *
     * @param App\Services\PromptService $service
     * @param int|null                   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditPrompt(Request $request, PromptService $service, $id = null)
    {
        $id ? $request->validate(Prompt::$updateRules) : $request->validate(Prompt::$createRules);
        $data = $request->only([
            'name', 'prompt_category_id', 'summary', 'description', 'start_at', 'end_at', 'hide_before_start', 'hide_after_end', 'is_active', 'rewardable_type',
             'rewardable_id', 'quantity', 'image', 'remove_image', 'prefix', 'hide_submissions', 'staff_only',
             'chara_exp', 'chara_points', 'user_exp', 'user_points', 'level_req', 'level_check', 'skill_id', 'skill_quantity'
        ]);
        if ($id && $service->updatePrompt(Prompt::find($id), $data, Auth::user())) {
            flash('Prompt updated successfully.')->success();
        } elseif (!$id && $prompt = $service->createPrompt($data, Auth::user())) {
            flash('Prompt created successfully.')->success();

            return redirect()->to('admin/data/prompts/edit/'.$prompt->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Gets the prompt deletion modal.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeletePrompt($id)
    {
        $prompt = Prompt::find($id);

        return view('admin.prompts._delete_prompt', [
            'prompt' => $prompt,
        ]);
    }

    /**
     * Deletes a prompt.
     *
     * @param App\Services\PromptService $service
     * @param int                        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeletePrompt(Request $request, PromptService $service, $id)
    {
        if ($id && $service->deletePrompt(Prompt::find($id))) {
            flash('Prompt deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->to('admin/data/prompts');
    }
}

<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\Character\CharacterTransformation as Transformation;
<<<<<<< HEAD
=======
use App\Models\Species\Species;
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
use App\Services\TransformationService;
use Auth;
use Illuminate\Http\Request;

class TransformationController extends Controller {
    /**
     * Shows the transformation index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTransformationIndex() {
<<<<<<< HEAD
        return view('admin.transformations.transformations', [
=======
        return view('admin.specieses.transformations', [
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
            'transformations' => Transformation::orderBy('sort', 'DESC')->get(),
        ]);
    }

    /**
     * Shows the create transformation page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateTransformation() {
<<<<<<< HEAD
        return view('admin.transformations.create_edit_transformation', [
            'transformation' => new Transformation,
=======
        return view('admin.specieses.create_edit_transformation', [
            'transformation' => new Transformation,
            'specieses'      => Species::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
        ]);
    }

    /**
     * Shows the edit transformation page.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditTransformation($id) {
        $transformation = Transformation::find($id);
        if (!$transformation) {
            abort(404);
        }

<<<<<<< HEAD
        return view('admin.transformations.create_edit_transformation', [
            'transformation' => $transformation,
=======
        return view('admin.specieses.create_edit_transformation', [
            'transformation' => $transformation,
            'specieses'      => Species::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
        ]);
    }

    /**
     * Creates or edits a transformation.
     *
     * @param App\Services\TransformationService $service
     * @param int|null                           $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditTransformation(Request $request, TransformationService $service, $id = null) {
        $id ? $request->validate(Transformation::$updateRules) : $request->validate(Transformation::$createRules);
        $data = $request->only([
<<<<<<< HEAD
            'name', 'description', 'image', 'remove_image',
        ]);
        if ($id && $service->updateTransformation(Transformation::find($id), $data, Auth::user())) {
            flash(ucfirst(__('transformations.transformation')).' updated successfully.')->success();
        } elseif (!$id && $transformation = $service->createTransformation($data, Auth::user())) {
            flash(ucfirst(__('transformations.transformation')).' created successfully.')->success();
=======
            'species_id', 'name', 'description', 'image', 'remove_image',
        ]);
        if ($id && $service->updateTransformation(Transformation::find($id), $data, Auth::user())) {
            flash('Transformation updated successfully.')->success();
        } elseif (!$id && $transformation = $service->createTransformation($data, Auth::user())) {
            flash('Transformation created successfully.')->success();
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317

            return redirect()->to('admin/data/transformations/edit/'.$transformation->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }

    /**
     * Gets the transformation deletion modal.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteTransformation($id) {
        $transformation = Transformation::find($id);

<<<<<<< HEAD
        return view('admin.transformations._delete_transformation', [
=======
        return view('admin.specieses._delete_transformation', [
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
            'transformation' => $transformation,
        ]);
    }

    /**
     * Deletes a transformation.
     *
     * @param App\Services\TransformationService $service
     * @param int                                $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteTransformation(Request $request, TransformationService $service, $id) {
        if ($id && $service->deleteTransformation(Transformation::find($id))) {
<<<<<<< HEAD
            flash(ucfirst(__('transformations.transformation')).' deleted successfully.')->success();
=======
            flash('Transformation deleted successfully.')->success();
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->to('admin/data/transformations');
    }

    /**
     * Sorts transformations.
     *
     * @param App\Services\TransformationService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortTransformations(Request $request, TransformationService $service) {
        if ($service->sortTransformations($request->get('sort'))) {
<<<<<<< HEAD
            flash(ucfirst(__('transformations.transformation')).' order updated successfully.')->success();
=======
            flash('Transformation order updated successfully.')->success();
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> f14981977a1fcff1c1fe35375b985aa9582ff317

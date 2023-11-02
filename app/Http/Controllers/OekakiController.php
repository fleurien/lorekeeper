<?php

namespace App\Http\Controllers;

use App\Models\Gallery\Gallery;
use App\Services\GalleryManager;
use Auth;
use Cache;
use Illuminate\Http\Request;
use View;

class OekakiController extends Controller {
    /**
     * Create a new controller instance.
     */
    public function __construct() {
        parent::__construct();
        View::share('sidebarGalleries', Gallery::whereNull('parent_id')->visible()->sort()->get());
    }

    /**
     * Returns the oekaki index.
     *
     * @return \Illuminate\View\View
     */
    public function getIndex() {
        // this is hacky, if you got a better idea PLEASE let me know
        $files = glob(public_path('images/oekaki/'.Auth::user()->id.'.*'));
        // if a .chi exists prefer that over a .png
        if ($files) {
            $file = (count($files) > 1) ? $files[1] : $files[0];
            // get file url
            $url = url('images/oekaki/'.Auth::user()->id.'.'.pathinfo($file, PATHINFO_EXTENSION));
        }

        return view('galleries.oekaki', [
            'galleryPage' => false,
            'sideGallery' => null,
            'url'         => $url ?? null,
        ]);
    }

    /**
     * Saves an oekaki .png / .chi temporary file.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSave(GalleryManager $service, Request $request) {
        if (!$url = $service->saveOekakiImage($request->only('file'), Auth::user())) {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        } else {
            // get image from cache
            flash('Oekaki loaded successfully!')->success();
        }

        return redirect()->to('oekaki');
    }

    /**
     * publishes an oekaki to the gallery.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postPublish(GalleryManager $service, Request $request) {
        if (!$request->hasFile('picture')) {
            return response()->json('No file uploaded', 400);
        }

        if (!$submission = $service->createOekakiSubmission($request->only('picture'), Auth::user())) {
            return response()->json(implode(' ', $service->errors()->getMessages()['error']), 404);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'CHIBIOK',
            'url'     => $submission->url,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Auth;
use Illuminate\Http\Request;
use Settings;

class OekakiController extends Controller {

    /**
     * Returns the oekaki index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return view('home.oekaki', [
            'user' => Auth::user(),
        ]);
    }
}

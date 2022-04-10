<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use App\Services\LinkService;
use App\Services\UserService;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Settings;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Affiliate;
use App\Services\DeviantArtService;
class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | Displays the homepage and handles redirection for linking a user's social media account.
    |
    */

    /**
     * Shows the homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('welcome', [
            'about' => SitePage::where('key', 'about')->first(),
        ]);
    }

    /**
     * Shows the account linking page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getLink(Request $request)
    {
        // If the user already has a username associated with their account, redirect them
        if (Auth::check() && Auth::user()->hasAlias) {
            redirect()->to('home');
        }

        // Display the login link
        return view('auth.link');
    }

    /**
     * Redirects to the appropriate provider.
     *
     * @param string $provider
     */
    public function getAuthRedirect(LinkService $service, $provider)
    {
        if (!$this->checkProvider($provider, Auth::user())) {
            flash($this->error)->error();

            return redirect()->to(Auth::user()->has_alias ? 'account/aliases' : 'link');
        }

        // Redirect to the provider's authentication page
        return $service->getAuthRedirect($provider); //Socialite::driver($provider)->redirect();
    }

    /**
     * Redirects to the appropriate provider.
     *
     * @param string $provider
     */
    public function getAuthCallback(LinkService $service, $provider)
    {
        if (!$this->checkProvider($provider, Auth::user())) {
            flash($this->error)->error();

            return redirect()->to(Auth::user()->has_alias ? 'account/aliases' : 'link');
        }

        $result = Socialite::driver($provider)->user();
        if ($service->saveProvider($provider, $result, Auth::user())) {
            flash('Account has been linked successfully.')->success();
            Auth::user()->updateCharacters();
            Auth::user()->updateArtDesignCredits();

            return redirect()->to('account/aliases');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

            return redirect()->to(Auth::user()->has_alias ? 'account/aliases' : 'link');
        }

        return redirect()->to('/');
    }

    /**
     * Shows the birthdaying page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBirthday(Request $request)
    {
        // If the user already has a username associated with their account, redirect them
        if (Auth::check() && Auth::user()->birthday) {
            return redirect()->to('/');
        }

        // Step 1: display a login birthday
        return view('auth.birthday');
    }

    /**
     * Posts the birthdaying page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postBirthday(Request $request)
    {
        $service = new UserService;
        // Make birthday into format we can store
        $data = $request->input('dob');
        $date = $data['day'].'-'.$data['month'].'-'.$data['year'];
        $formatDate = Carbon::parse($date);

        if ($service->updateBirthday($formatDate, Auth::user())) {
            flash('Birthday added successfully!');

            return redirect()->to('/');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

            return redirect()->back();
        }
    }

    /**
     * Shows the birthdaying page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBirthdayBlocked(Request $request)
    {
        // If the user already has a username associated with their account, redirect them
        if (Auth::check() && Auth::user()->checkBirthday) {
            return redirect()->to('/');
        }

        if (Auth::check() && !Auth::user()->birthday) {
            return redirect()->to('birthday');
        }

        // Step 1: display a login birthday
        return view('auth.blocked');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('guest')->except('logout');
    }

    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderFacebookCallback()
    {

        $auth_user = Socialite::driver('facebook')->user();
        $existUser = User::where('email',$auth_user->email)->first();
        // dd($auth_user);

        if($existUser) {
            Auth::login($existUser,true);
        }
        else {
            $user = new User;
            $user->name = $auth_user->name;
            $user->email = $auth_user->email;
            $user->token = $auth_user->token;
            $user->save();
            Auth::login($user, true);
        }
        // return redirect()->to('/home');
        return redirect()->to('/home'); // Redirect to a secure page
    }
}

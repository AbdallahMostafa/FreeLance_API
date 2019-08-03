<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;
use Exception;

class SocialAuthGoogleController extends Controller
{
  public function redirect()
  {
      return Socialite::driver('google')->redirect();
  }


  public function callback()
  {
      try {


          $googleUser = Socialite::driver('google')->user();
          $existUser = User::where('email',$googleUser->email)->first();


          if($existUser) {
              Auth::login($existUser, true);
          }
          else {
              $user = new User;
              $user->name = $googleUser->name;
              $user->email = $googleUser->email;
              $user->token = $googleUser->token;
              $user->password = md5(rand(1,10000));
              $user->save();
              Auth::login($user,true);
          }
          return redirect()->to('/home');
      }
      catch (Exception $e) {
          return $e;
      }
  }
}

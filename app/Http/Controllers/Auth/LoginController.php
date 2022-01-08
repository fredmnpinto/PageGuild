<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // override default login
    public function login(Request $request)
    {
       $input = $request->all();

       $this->validate($request, [
        'username/email' => 'required',
        'password' => 'required',
        ]);

        if(auth()->attempt(array('username' => $input['username/email'], 'password' => $input['password']))) { // 1º tentativa
            return redirect()->route('home');
        }else if(auth()->attempt(array('email' => $input['username/email'], 'password' => $input['password']))) { // 2º tentativa
            return redirect()->route('home');
        }else{
            return redirect()->route('login')
                ->with('error','Username or Email-Address And Password Are Wrong.');
        }
    }
}

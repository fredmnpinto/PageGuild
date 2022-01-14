<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Gloudemans\Shoppingcart\Facades\Cart;
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

    /**
     * Essa funcao corre sempre que o usuario faz login
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function authenticated(Request $request, User $user)
    {
        /* Busca o carrinho de compras daquele usuario da base de dados */
        Cart::restore($user);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        /* Guarda o carrinho na base de dados antes de fazer o logout do usuario */
        Cart::store(auth()->user());

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}

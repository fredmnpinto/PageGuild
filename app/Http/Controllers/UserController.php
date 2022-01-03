<?php
namespace App\Http\Controllers;

use Auth;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use App\Models\Address;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('profile.profileView', ['users' => $users]);
    }

    /**
     * Popula a pagina "As minhas informações pessoais" ou userInfo.blade.php
     */
    public function showUserInfo() {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = User::find(Auth::user()->id);

        // Vai buscar os endereços do utilizador
        $activeAddress = Address::where(function ($query) use($user) {
            $query->where('user_id','=',$user->id)
                  ->where('flg_active','=',true);
        })->get();
        $deactiveAddress = Address::where(function ($query) use($user) {
            $query->where('user_id','=',$user->id)
                  ->where('flg_active','=',false);
        })->get();

        return view('profile.userInfo', ['user' => $user, 'activeAddress' => $activeAddress, 'deactiveAddress' => $deactiveAddress]);
    }

    /**
     * Atualiza a informação de um utilizador
     * 
     * Esta função e chamada quando atualizamos alguma informação
     */
    public function updateUserInfo(Request $request) {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = User::find(Auth::user()->id);

        /**
         * Valida as informacaoes. Por exemplo, se o email e unico.
         *
         * @link https://laravel.com/docs/8.x/validation#quick-displaying-the-validation-errors
         * 
         * @author Gabriel
         */ 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'nif' => 'required',
        ]);

        /**
         * Adiciona regras especiais, para no caso de por exemplo o email não ter sido atualizado não faz sentido este ser validado como unico visto que e o mesmo.
         * 
         * @link https://laravel.com/docs/5.2/validation#conditionally-adding-rules
         * 
         * @author Gabriel
         */
        $validator->sometimes('email', 'unique:user', function($input) use ($user, $request) {
            //Se o email do utilizador for diferente do novo email, significa que e um email novo e tem que ser validado como unico
            return $user->email != $request->email;
        });


        // Se a validação falhar o laravel retorna o erro de validacao na pagina
        if ($validator->fails()) {
            return redirect()->route('userInfo')
                        ->withErrors($validator, 'userInfo');
        }

        // Faz update das variaveis novas
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nif = $request->nif;

        $user->save();

        return redirect()->route('userInfo');
    }
}

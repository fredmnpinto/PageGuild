<?php
namespace App\Http\Controllers;

use Auth;
use Validator;

use Illuminate\Database\Query\Builder;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use App\Models\City;
use App\Models\Country;
use App\Models\Address;
use App\Models\User;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AddressController;

class UserController extends Controller
{
    /**
     * Funcao chamada por default quando o utilizador acessa o profile
     */
    public function index()
    {
        return redirect()->route('userAddress');
    }

    /**
     * Popula a pagina "As minhas informações pessoais" ou userInfo.blade.php
     */
    public function showUserInfo() {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = User::find(Auth::user()->id);

        return view('profile.userInfo', ['user' => $user]);
    }

    /**
     * Popula a pagina "Os meus endereçõs" ou userAdress.blade.php
     */
    public function showUserAddress() {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = User::find(Auth::user()->id);

        // Vai buscar os endereços do utilizador
        $activeAddress = AddressController::buildSearchAddressQuery($user->id, ['address.id','user_id', 'address','country','city','flg_active','flg_delete'], 'true')->get();
        $deactiveAddress = AddressController::buildSearchAddressQuery($user->id, ['address.id','user_id','address','country','city','flg_active','flg_delete'],'false')->get();
        
        // Vai buscar todas as opçoes de cidades da base de dados
        $countryCity_list = AddressController::listCountryCity();

        return view('profile.userAddress', ['activeAddress' => $activeAddress, 'deactiveAddress' => $deactiveAddress, 'cityList' => $countryCity_list]);
    }

    /**
     * Popula a pagina "As minhas encomendas" ou userOrders.blade.php
     */
    public function showUserOrders() {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = User::find(Auth::user()->id);

        $orders = OrderController::buildSearchOrdersQuery($user->id, ['order.id', 'order_status.status', 'registration_date', 'update_date', 'coupon_id'])->get();

        return view('profile.userOrders', ['orders' => $orders]);
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

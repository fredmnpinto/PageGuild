<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Query\Builder;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

use App\Models\City;
use App\Models\Country;
use App\Models\Address;
use App\Models\User;

use Illuminate\Support\Facades\Storage;

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
        $user = Auth::user();

        return view('profile.userInfo', ['user' => $user]);
    }

    /**
     * Popula a pagina "Os meus endereçõs" ou userAdress.blade.php
     */
    public function showUserAddress() {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = Auth::user();

        // Vai buscar os endereços do utilizador
        $activeAddress = AddressController::buildSearchAddressQuery($user->id, ['address.id','user_id', 'address','country','city','flag_active','flag_delete'], 'true')->get();
        $deactiveAddress = AddressController::buildSearchAddressQuery($user->id, ['address.id','user_id','address','country','city','flag_active','flag_delete'],'false')->get();

        // Vai buscar todas as opçoes de cidades da base de dados
        $countryCity_list = AddressController::listCountryCity();

        return view('profile.userAddress', ['activeAddress' => $activeAddress, 'deactiveAddress' => $deactiveAddress, 'cityList' => $countryCity_list]);
    }

    /**
     * Popula a pagina "As minhas encomendas" ou userOrders.blade.php
     */
    public function showUserOrders() {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = Auth::user();

        $ordersData = OrderController::getPastOrders($user);

        return view('profile.userOrders', compact('ordersData'));
    }

    /**
     * Atualiza a informação de um utilizador
     *
     * Esta função e chamada quando atualizamos alguma informação
     */
    public function updateUserInfo(Request $request) {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = Auth::user();

        /**
         * Valida as informacaoes. Por exemplo, se o email e unico.
         *
         * @link https://laravel.com/docs/8.x/validation#quick-displaying-the-validation-errors
         *
         * @author Gabriel
         */
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        /**
         * Adiciona regras especiais, para no caso de por exemplo o email não ter sido atualizado não faz sentido este ser validado como unico visto que e o mesmo.
         *
         * @link https://laravel.com/docs/5.2/validation#conditionally-adding-rules
         *
         * @author Gabriel
         */
        $validator->sometimes('email', 'unique:users', function($input) use ($user, $request) {
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

    public function itemsInShoppingCart() {
        $user = Auth::user();

        $query = DB::table('item', 'i')
            ->join('shopping_cart sc', 'sc.user_id', '=', "{$user->id}")
            ->where('i.flag_delete', 'is not', 'true')
            ->where('sc.flag_delete', 'is not', 'true');

        return $query->get('i.id');
    }

    /**
     * Faz upload de uma imagem e define-a como a nova foto de perfil do utilizador
     *
     * @author Gabriel
     */
    public function uploadProfileImage(Request $request) {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = Auth::user();

        //Elimina imagem anterior do utilizador
        Storage::delete('public/image/'.$user->img_path);

        /**
         * Valida as informacaoes. Por exemplo, se o email e unico.
         *
         * @link https://laravel.com/docs/8.x/validation#quick-displaying-the-validation-errors
         *
         * @author Gabriel
         */
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        // Se a validação falhar o laravel retorna o erro de validacao na pagina
        if ($validator->fails()) {
            return redirect()->route('userInfo')
                        ->withErrors($validator, 'userInfo');
        }

        // Guarda a imagem no servidor
        $request->file('image')->store('public/image');

        // Guarda a path no utilizador
        $user->img_path = $request->file('image')->hashName();
        $user->save();

        return redirect()->route('userInfo')->with("Status", "Image has been uploaded");
    }
}

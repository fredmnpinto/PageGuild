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

    public function showUserAddress() {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = User::find(Auth::user()->id);

        // Vai buscar os endereços do utilizador
        $activeAddress = UserController::buildSearchAddressQuery($user->id, ['address.id','user_id', 'address','country','city','flg_active','flg_delete'], 'true')->get();
        $deactiveAddress = UserController::buildSearchAddressQuery($user->id, ['address.id','user_id','address','country','city','flg_active','flg_delete'],'false')->get();
        
        // Vai buscar todas as opçoes de cidades da base de dados
        $countryCity_list = AddressController::listCountryCity();

        return view('profile.userAddress', ['activeAddress' => $activeAddress, 'deactiveAddress' => $deactiveAddress, 'cityList' => $countryCity_list]);
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

    /**
     * Constroi a query para buscar todos os address de um utilizador
     * Se forem aplicados filtros na pesquisa, ela tambem aplica
     * 
     * @param int $user_id Id do utilizador que pretendemos obter os address
     * 
     * @return Builder
     * 
     * @author Gabriel
     */
    public function buildSearchAddressQuery(int $user_id, array $selectArgs, string $flg_active = null) : Builder {
        $query = DB::table('address')
                ->select($selectArgs) // Podemos passar um array de tamanho indefinido
                ->join('city','address.city_id','=','city.id')
                ->join('country','city.country_id','=','country.id');

        /**
         * Pesquisa por todos os address que pertencam ao user @param $user_id e que não estejam eliminados
         * 
         * @author Gabriel
         */
        $query = $query->where( function ($query) use($user_id) {
            $query->where('address.user_id','=',$user_id);
            $query->where('flg_delete','=','false');
        }); 

        /**
         * Parte onde são aplicaados os filtros
         * 
         * @author Gabriel
         */
        $query = $query->where(function ($query) use($flg_active) {
            if($flg_active != null) {
                $query->where('address.flg_active','=', $flg_active);
            }
        });

        return $query;
    }

    /**
     * Esta função e responsavel por desativar um endereço
     * 
     * Ela e chamada pela rota "desactivateAddress"
     * 
     * @author Gabriel
     */
    public function desactivateAddress($address_id) {
        $address = Address::find($address_id);

        $address->flg_active = false;

        $address->save();

        return redirect()->route('userAddress');
    }

    /**
     * Esta função e responsavel por ativar um endereço
     * 
     * Ela e chamada pela rota "activateAddress"
     * 
     * @author Gabriel
     */
    public function activateAddress($address_id) {
        $address = Address::find($address_id);

        $address->flg_active = true;

        $address->save();

        return redirect()->route('userAddress');
    }

    /**
     * Esta função e responsavel por eliminar um endereço
     * 
     * Ela e chamada pela rota "deleteAddress"
     * 
     * @author Gabriel
     */
    public function deleteAddress($address_id) {
        $address = Address::find($address_id);

        $address->flg_delete = true;

        $address->save();

        return redirect()->route('userAddress');
    }

    /**
     * Esta função e responsavel por criar um endereço
     * 
     * Ela e chamada pela rota "createAddress"
     * 
     * @author Gabriel
     */
    public function createAddress(Request $request) {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = User::find(Auth::user()->id);

        /**
         * Valida as informacaoes.
         *
         * @link https://laravel.com/docs/8.x/validation#quick-displaying-the-validation-errors
         * 
         * @author Gabriel
         */ 
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'address' => 'required',
        ]);

        // Se a validação falhar o laravel retorna o erro de validacao na pagina
        if ($validator->fails()) {
            return redirect()->route('userAddress')
                        ->withErrors($validator, 'userAddress');
        }

        // Cria o registro do novo address
        DB::table('address')->insert([
            'city_id' => $request->city,
            'address' => $request->address,
            'flg_active' => true,
            'flg_delete' => false,
            'user_id' => $user->id
        ]);

        return redirect()->route('userAddress');
    }
}

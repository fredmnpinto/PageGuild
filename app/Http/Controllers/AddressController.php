<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Query\Builder;

use App\Models\Address;
use App\Models\User;

use Auth;
use Validator;

use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Vai buscar todas as diferences cidades da base de dados
     * Esta funcao e utilizada para popular as options do select de cidade quando um utilizador cria um address
     *
     * @author Gabriel
     */
    public static function listCountryCity() {
        return DB::table('city')
            ->join('country','city.country_id','=','country.id')
            ->select('city.id as city_id','country.id as country_id','city','country')
            ->get();
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
    public static function buildSearchAddressQuery(int $user_id, array $selectArgs, string $flag_active = null) : Builder {
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
            $query->where('flag_delete','=','false');
        });

        /**
         * Parte onde são aplicaados os filtros
         *
         * @author Gabriel
         */
        $query = $query->where(function ($query) use($flag_active) {
            if($flag_active != null) {
                $query->where('address.flag_active','=', $flag_active);
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
    public static function desactivateAddress($address_id) {
        $address = Address::find($address_id);

        $address->flag_active = false;

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
    public static function activateAddress($address_id) {
        $address = Address::find($address_id);

        $address->flag_active = true;

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
    public static function deleteAddress($address_id) {
        $address = Address::find($address_id);

        $address->flag_delete = true;

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
    public static function createAddress(Request $request) {
        // Vai buscar o utilizador que esta neste momento autenticado
        $user = Auth::user();

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
            'flag_active' => true,
            'flag_delete' => false,
            'user_id' => $user->id
        ]);

        return redirect()->route('userAddress');
    }
}

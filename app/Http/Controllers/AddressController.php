<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}

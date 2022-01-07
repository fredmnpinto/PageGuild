<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Query\Builder;

class OrderController extends Controller
{
     /**
     * Constroi a query para buscar todos as orders de um utilizador
     * Se forem aplicados filtros na pesquisa, ela tambem aplica
     * 
     * @param int $user_id Id do utilizador que pretendemos obter as orders
     * 
     * @return Builder
     * 
     * @author Gabriel
     */
    public static function buildSearchOrdersQuery(int $user_id, array $selectArgs) : Builder {
        $query = DB::table('order')
                ->select($selectArgs) // Podemos passar um array de tamanho indefinido
                ->join('order_status','order_status.id','=','order.order_status_id');

        /**
         * Pesquisa por todos as orders que pertencam ao user @param $user_id
         * 
         * @author Gabriel
         */
        $query = $query->where( function ($query) use($user_id) {
            $query->where('order.user_id','=',$user_id);
        }); 

        /**
         * Parte onde são aplicaados os filtros
         * 
         * @author Gabriel
         */
        $query = $query->where(function ($query) {
            
        });

        return $query;
    }
}

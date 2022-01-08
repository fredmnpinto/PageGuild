<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Item;
use App\Models\ItemShoppingCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;


use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Stripe\Stripe;


class OrderController extends Controller
{

    /**
     * Adiciona um item ao carrinho
     *
     */
    public function addToCart(Request $request): RedirectResponse
    {
        $user = $request->user();
        $item_id = $request->get('item_id');

        if ($item_id == null) {
            return back()->with('error', __('System Error: Item not provided to addToCart()'));
        }

        DB::table('shopping_cart')
            ->insert(
                [
                    'item_id' => $item_id,
                    'user_id' => $user->id,
                    'registration_date' => 'now()',
                    'flg_delete' => 'false',
                ]
            );

        return back()->with('message', __('Item was added to your cart'));
    }

    /**
     * Retorna a view com o carrinho de compras
     *
     */
    public function shoppingCart() {
        $user = auth()->user();

        $items = $user->shoppingCart()->get();

        return view('order.shopping_cart', compact('items'));
    }

    /**
     *
     */
    public function checkout() {
        $user = auth()->user();
        $intent = $user->createSetupIntent();
        $items = $user->shoppingCart()->get();
        $total_amount = 0;

        foreach($user->shoppingCart()->get() as $itemInCart) {
            $total_amount += $itemInCart->price;
        }

        return view('order.checkout', compact('items', 'intent', 'total_amount'));
    }

    public function purchase(Request $request) {
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');
        $fullPrice = $request->get('total_amount');

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            /* Stripe faz as cobranças em cêntimos, por isso é preciso multiplicar por 100 o preço */
            $user->charge($fullPrice * 100, $paymentMethod);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('message', 'Product purchased successfully!');
    }

    private function createOrder(array $items, User $user, int $coupon_id = null) {
        $order = new Order;
        $order->setAttribute('coupon_id', $coupon_id);
        $order->setAttribute('registration_date', 'now()');
        $order->setAttribute('order_status_id', 3); /* 1 -> Waiting for Payment; 2 -> Processing Payment; 3 -> Payment Complete */
        $order->save();

        foreach($items as $item) {
            $orderItem = new OrderItem;
        }
    }

     /**
     * Constroi a query para buscar todos as orders de um utilizador
     * Se forem aplicados filtros na pesquisa, ela tambem aplica
     *
     * @param int $user_id Id do utilizador que pretendemos obter as orders
     *
     * @return Builder
     */
    public static function buildSearchOrdersQuery(int $user_id, array $selectArgs) : Builder {
        $query = DB::table('order')
                ->select($selectArgs) // Podemos passar um array de tamanho indefinido
                ->join('order_status','order_status.id','=','order.order_status_id');

        /**
         * Pesquisa por todos as orders que pertencam ao user @param $user_id
         *
         */
        $query = $query->where( function ($query) use($user_id) {
            $query->where('order.user_id','=',$user_id);
        });

        /**
         * Parte onde são aplicaados os filtros
         *
         */
        $query = $query->where(function ($query) {

        });

        return $query;
    }
}

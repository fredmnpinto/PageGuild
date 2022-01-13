<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Item;
use App\Models\ItemShoppingCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;
use Nette\Utils\DateTime;
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

        /* Checa se o item de input é null ou um item deletado */
        if ($item_id == null or Item::find($item_id)->flag_delete) {
            return back()->with('error', __('The selected item is not available'));
        }

        DB::table('shopping_cart')
            ->insert(
                [
                    'item_id' => $item_id,
                    'user_id' => $user->id,
                    'registration_date' => (new DateTime)->format('Y-m-d h:i:s'),
                    'flag_active' => true,
                    'flag_delete' => false,
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
     * View do checkout
     *
     * Middleware: cart_not_empty -> Nao se pode fazer checkout de carrinho vazio
     */
    public function checkout() {
        $user = auth()->user();
        $intent = $user->createSetupIntent(); /* Stripe buy intent */
        $shoppingCartItems = self::getShoppingCartItems(); /* Itens em forma de uma Collection do Eloquent */

        $total_amount = 0;

        foreach($shoppingCartItems as $itemInCart) {
            $total_amount += $itemInCart->price;
        }

        return view('order.checkout', compact('shoppingCartItems', 'intent', 'total_amount'));
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

        self::createOrder(self::getShoppingCartItems(), $user);

        self::emptyCart($user);

        return redirect(route('home'))->with('message', 'Purchase completed successfully!');
    }

    public static function getShoppingCartItems() {
        $user = auth()->user();

        return $user->shoppingCart()
            ->where('shopping_cart.flag_delete', false)
            ->where('shopping_cart.flag_active', true)
            ->where('item.flag_delete', false)
            ->groupBy(['item.id', 'shopping_cart.user_id', 'shopping_cart.item_id'])
            ->get(['item.*', DB::raw('count(shopping_cart.id) as amount')]);
    }

    /**
     * Checa se o carrinho de compras do usuario validado está vazio
     *
     * @return bool
     */
    public static function isShoppingCartEmpty() : bool {
        return count(self::getShoppingCartItems()) == 0;
    }

    private static function createOrder(Collection $items, User $user, int $coupon_id = null) : Order {
        $now = new DateTime;
        $now = $now->format('Y-m-d h:i:s');

        $order_id = DB::table('order')
            ->insertGetId([
                'user_id' => $user->id,
                'registration_date' => $now,
                'order_status_id' => 3,
                'update_date' => $now,
                'coupon_id' => $coupon_id
            ]);

        $orderItems = [];
        foreach($items as $item) {
            $orderItem = [
                'order_id' => $order_id,
                'item_id' => $item->id,
                'amount' => $item->amount,
            ];

            $orderItems[] = $orderItem;
        }

        OrderItem::insert($orderItems);

        return Order::find($order_id);
    }

    public static function emptyCart(User $user) : void {
        DB::table('shopping_cart')
            ->where('flag_active', '=', true)
            ->where('user_id', '=', $user->id)
            ->update(['flag_active' => false]);
    }

    /**
     * Constroi a query para buscar todos as orders de um utilizador
     * Se forem aplicados filtros na pesquisa, ela tambem aplica
     *
     * @param int $user_id Id do utilizador que pretendemos obter as orders
     * @param array $selectArgs
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

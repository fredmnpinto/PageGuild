<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Item;
use App\Models\ItemShoppingCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\User;


use Gloudemans\Shoppingcart\Facades\Cart;
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

        $item = Item::find($item_id);

        /* Checa se o item de input é null ou um item deletado */
        if ($item_id == null or $item == null or $item->flag_delete) {
            return back()->with('error', __('The selected item is not available'));
        }

        Cart::instance('shopping')->add($item, 1);

        return back()->with('message', __('Item foi adicionad ao carrinho com sucesso'));
    }

    /**
     * Remove o item desejado do carrinho do
     * utilizador atual
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeFromCart(Request $request) {
        $request->validate([
            "item_id" => "required|exists:item,id"
        ]);

        $item_id = $request->get('item_id');

        /* Retorna todos os artigos desse id presentes no carrinho */
        $itemToRemove = Cart::instance('shopping')->search(function ($cartItem, $rowId) use ($item_id) {
            return $cartItem->id == $item_id;
        })->first();
        /* @first() Porque ele devolve uma Collection de todos os items com esse ID,
         mas tera sempre 1 unico item porque o ID é único */

        /* Se for devolvida uma colecao vazia, o item nao estava no carrinho */
        if ($itemToRemove == null) {
            return back()->with('error', __("Item não encontrado no carrinho"));
        }

        $newQuantity = $itemToRemove->qty - 1;

        /* Caso a quantidade se torne 0, ele automaticamente remove o item do carrinho */
        Cart::instance('shopping')->update($itemToRemove->rowId, $newQuantity);

        /* Se depois de remover o item, o carrinho estiver vazio, deve retornar a pagina inicial com um aviso */
        if (Cart::instance('shopping')->count() == 0) {
            return redirect(route('home'))->with('message', __("Seu carrinho agora está vazio"));
        }

        return back()->with('message', __('Item foi removido do carrinho com sucesso'));
    }

    /**
     * Checa se o carrinho contem o item especificado
     *
     * @param Item $item
     * @return bool
     */
    public static function cartContains(Item $item) {
        $item_id = $item->id;

        /* Items com o id do item especificado, devolve uma Collection com 1 ou 0 itens */
        $cartItems = Cart::instance('shopping')->search(function ($cartItem, $rowId) use ($item_id) {
            return $cartItem->id == $item_id;
        });

        return $cartItems->count() > 0;
    }

    /**
     * Retorna a view com o carrinho de compras
     *
     */
    public function shoppingCart() {
        $items = self::getShoppingCartItems();

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
        $total_amount_tax_included = self::getCartTotal(true);
        $total_amount = self::getCartTotal(false);
        $total_qty = Cart::instance('shopping')->count();

        return view('order.checkout', compact('shoppingCartItems', 'intent', 'total_amount', 'total_amount_tax_included', 'total_qty'));
    }

    /**
     * Funcao que fara a ligacao com o Stripe
     * para fazer de facto a venda do produto
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function purchase(Request $request) {
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');
        $fullPrice = Cart::instance('shopping')->total();

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            /* Stripe faz as cobranças em cêntimos, por isso é preciso multiplicar por 100 o preço */
            $user->charge($fullPrice * 100, $paymentMethod);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        self::createOrder(self::getShoppingCartItems(), $user);

        self::emptyCart();

        return redirect(route('home'))->with('message', 'Purchase completed successfully!');
    }

    public static function getShoppingCartItems() {
        return Cart::instance('shopping')->content();
    }

    /**
     * Checa se o carrinho de compras do usuario validado está vazio
     *
     * @return bool
     */
    public static function isShoppingCartEmpty() : bool {
        return count(self::getShoppingCartItems()) == 0;
    }

    /**
     * Busca o preco total da soma de itens no
     * carrinho de compras
     *
     * @param bool $tax - Impostos incluidos ou nao
     * @return float    - Preco total
     */
    public static function getCartTotal(bool $tax = true) {
        if ($tax) {
            return Cart::instance('shopping')->total();
        }
        return Cart::instance('shopping')->priceTotal();
    }

    /**
     * Salva a venda na base de dados
     *
     * @param Collection $items
     * @param User $user
     * @param int|null $coupon_id
     * @return Order
     */
    private static function createOrder($items, User $user, int $coupon_id = null) : Order {
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
                'amount' => $item->qty,
            ];

            $orderItems[] = $orderItem;
        }

        OrderItem::insert($orderItems);

        return Order::find($order_id);
    }

    /**
     * Apaga o registo que houver na base de dados
     * sobre o carrinho desse utilizador
     *
     * @param User $user
     * @return void
     */
    public static function emptyCart() : void {
        $user = auth()->user();
        Cart::destroy();
        Cart::erase($user);
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

    /**
     * Retorna o historico de compras de um usuario,
     * incluindo os itens presentes em cada compra
     *
     * @param User $user
     * @return array
     */
    public static function getPastOrders(User $user) {
        $userOrders = Order::where('user_id', $user->id)->get();

        $ordersDetails = [];
        foreach($userOrders as $order) {
            $status = OrderStatus::find($order->order_status_id)->status;
            $itemsInOrder = Item::join('order_item', 'order_item.item_id', 'item.id')
                ->where('order_item.order_id', $order->id)
                ->get(['item.id', 'item.name', 'item.price', 'order_item.amount']);

            $ordersDetails[] = [
                'order' => $order,
                'status' => $status,
                'items' => $itemsInOrder
            ];
        }

        return $ordersDetails;
    }
}

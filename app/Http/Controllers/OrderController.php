<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemShoppingCart;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
   
    /**
     * Adiciona um item ao carrinho 
     * 
     * @author Gabriel
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
     * @author Gabriel
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

        return view('order.checkout', compact('items', 'intent'));
    }

    public function purchase(Request $request) {
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');
        $fullPrice = 0;

        foreach($user->shoppingCart()->get() as $itemInCart) {
            $fullPrice += $itemInCart->price;
        }

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            /* Stripe faz as cobranças em cêntimos, por isso é preciso multiplar por 100 o preço */
            $user->charge($fullPrice * 100, $paymentMethod);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('message', 'Product purchased successfully!');
    }
}

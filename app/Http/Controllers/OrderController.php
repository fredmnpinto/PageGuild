<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemShoppingCart;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;

class OrderController extends Controller
{
    //

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
                    'registration_date' => 'now()'
                ]
            );

        return back()->with('message', __('Item was added to your cart'));
    }

    public function shoppingCart() {
        $user = auth()->user();

        $items = $user->shoppingCart()->get();

        return view('order.shopping_cart', compact('items'));
    }

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
}

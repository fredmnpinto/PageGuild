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
    //

    public function addToCart(Request $request, Item $item = null): RedirectResponse
    {
        $user = $request->user();

        if ($item == null) {
            return back()->with('error', __('System Error: Item not provided to addToCart()'));
        }

        DB::table('shopping_cart')
            ->insert(
                [
                    'item_id' => $item->id,
                    'user_id' => $user->id,
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

        return view('order.checkout', compact('items', 'intent'));
    }

    public function purchase(Request $request, Item $item) {
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');

        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            /* Stripe faz as cobranças em cêntimos, por isso é preciso multiplar por 100 o preço */
            $user->charge($item->price * 100, $paymentMethod);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('message', 'Product purchased successfully!');
    }
}

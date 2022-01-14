<?php

namespace App\Http\Middleware;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Closure;
use Illuminate\Http\Request;

class ShopCartNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (OrderController::isShoppingCartEmpty()) {
            return redirect('home')->with('error', __('You do not have items in your shopping cart'));
        }

        return $next($request);
    }
}

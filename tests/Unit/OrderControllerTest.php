<?php

namespace Unit;

use App\Models\User;
use App\Models\Item;

use App\Http\Controllers\OrderController;

use Gloudemans\Shoppingcart\Facades\Cart;

use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /**
     * Testa a função OrderController::cartContains()
     * 
     * Se um item não se encontra no carrinho e depois de adicionar, sim, então o teste passa
     * 
     * @author Gabriel
     */
    public function testCartContains() {
        // Vai buscar um item
        $item = Item::first();

        // Verifica se não existe
        $this->assertFalse(OrderController::cartContains($item));

        // Adiciona um item ao carrinho
        Cart::instance('shopping')->add($item, 1);

        // Verifica se foi adicionado
        $this->assertTrue(OrderController::cartContains($item));
    }

    /**
     * Testa a função OrderController::isShoppingCartEmpty()
     * 
     * Adiciona um item ao carrinho de compras, se ele estiver vazio o teste falha
     * 
     * @author Gabriel
     */
    public function testIsShoppingCartEmpty() {
        // Vai buscar um item
        $item = Item::first();

        // Adiciona um item ao carrinho
        Cart::instance('shopping')->add($item, 1);

        // Testa se não esta vazio
        $this->assertFalse(OrderController::isShoppingCartEmpty());
    }

    /**
     * Testa a função OrderController::createOrder()
     * 
     * Se a função retornar null, o teste falha
     * 
     * @author Gabriel 
     */
    public function testCreateOrder() {
        // Vai buscar um item e utilizador
        $items = Item::where('flag_delete','=','false');
        $user = User::first();

        // Testa se a order criada existe
        $this->assertNotNull(OrderController::createOrder($items, $user));
    }

    /**
     * @todo
     */
    public function testBuildSearchOrdersQuery() {
        $this->assertTrue(true);
    }

    /**
     * @todo
     */
    public function testGetPastOrders() {
        $this->assertTrue(true);
    }

}

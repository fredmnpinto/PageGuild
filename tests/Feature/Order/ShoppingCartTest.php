<?php

namespace Tests\Feature;

use App\Http\Controllers\OrderController;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    /**
     * Verifica se, depois de adicionar um item ao
     * carrinho, nao devolve um erro nem o carrinho
     * esta vazio.
     *
     * @author Frederico
     * @return void
     */
    public function test_add_to_cart() {
        $user = User::factory()->create();
        auth()->login($user);

        $this->assertTrue(OrderController::isShoppingCartEmpty(), "Usuario recem criado não deve ter um carrinho vazio");

        $itemToAdd = Item::factory()->create();
        $itemToAdd->setAttribute('flag_delete', false)->save();

        $this->assertDatabaseHas('item', ['name' => $itemToAdd->name, 'id' => $itemToAdd->id, 'flag_delete' => false]);

        $response = $this->post(route('order.add_to_cart'), ['item_id' => $itemToAdd->id]);

        $response->assertSessionMissing("error");

//        $this->assertFalse(OrderController::isShoppingCartEmpty(), "Carrinho não deve estar vazio depois de adicionar um item elegível");

        $this->assertTrue(OrderController::getShoppingCartItems()->contains($itemToAdd), "Carrinho deve conter o item adicionado");
    }

    /**
     * Verifica se, depois de chamar o post de
     * adicionar ao carrinho com o item_id a null,
     * é redirecionado com erros.
     *
     * @author Frederico
     * @return void
     */
    public function test_add_null_to_cart() {
        $user = User::factory()->create();
        auth()->login($user);

        $this->assertTrue(OrderController::isShoppingCartEmpty(), "User recem criado nao deve ter itens no carrinho");

        $response = $this->post(route('order.add_to_cart'));

        $response->assertStatus(302);

        $response->assertSessionHas('error');

        $this->assertTrue(OrderController::isShoppingCartEmpty(), "Carrinho deve estar vazio depois de um post add_to_cart falhar");
    }

    /**
     * Verifica se, depois de chamar o post de
     * adicionar ao carrinho com o item_id de
     * um item deletado, é redirecionado com
     * mensagem de erro.
     *
     * @author Frederico
     * @return void
     */
    public function test_add_deleted_item_to_cart() {
        $user = User::factory()->create();
        auth()->login($user);

        /* Carrinho inicial tem de estar vazio */
        $this->assertTrue(OrderController::isShoppingCartEmpty(), "User recem criado nao deve ter itens no carrinho");

        /* Garantir que o item criado para o teste é deletado */
        $item = Item::factory()->create();
        $item->setAttribute('flag_delete', true)->save();
        $this->assertDatabaseHas('item', ['id' => $item->id, 'name' => $item->name, 'flag_delete' => true]);

        $response = $this->post(route('order.add_to_cart', ['item_id' => $item->id]));

        /* Garantir que o usuário é redirecionado com erros */
        $response->assertStatus(302);
        $response->assertSessionHas('error');

        /* Garantir que o carrinho continua vazio depois de falhar em adicionar um item */
        $this->assertTrue(OrderController::isShoppingCartEmpty(), "Carrinho deve estar vazio depois de um post add_to_cart falhar");
    }

    /**
     * Checa se a funcao de esvaziar o carrinho
     * esvazia o carrinho de compras
     *
     * @author Frederico
     * @return void
     */
    public function test_empty_cart_empties_cart() {
        $user = User::factory()->create();
        auth()->loginUsingId($user->id);

        $this->assertTrue(OrderController::isShoppingCartEmpty(), "User recem criado nao deve ter itens no carrinho");

        $response = $this->post(route('order.add_to_cart'), ["item_id" => Item::where('flag_delete', false)->first()->id]);

        OrderController::emptyCart($user);

        $this->assertTrue(OrderController::isShoppingCartEmpty(), "Carrinho deve estar vazio depois de emptyCart()");

    }

    /**
     * Checa se ao chamar o checkout com o
     * carrinho vazio, devolve um erro e
     * redireciona para outro lugar.
     *
     * @author Frederico
     * @return void
     */
    public function test_checkout_with_empty_cart() {
        $user = User::factory()->create();
        auth()->loginUsingId($user->id);

        $this->assertTrue(OrderController::isShoppingCartEmpty(), "User recem criado nao deve ter itens no carrinho");

        $response = $this->get(route('order.checkout'));

        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }

    /**
     * Checa se ao tentar fazer checkout sem antes
     * fazer login, ele devolve um erro e nos direciona
     * a tela de login.
     *
     * @author Frederico
     * @return void
     */
    public function test_checkout_without_login() {
        $response = $this->assertGuest()->get(route('order.checkout'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
    }

    /**
     * Checa se ao tentar fazer checkout sem antes
     * fazer login, ele devolve um erro e nos direciona
     * a tela de login.
     *
     * @author Frederico
     * @return void
     */
    public function test_get_checkout_ok() {
        auth()->login(User::first());

        $item = Item::factory()->create();
        $item->setAttribute('flag_delete', false)->save();
        $this->assertDatabaseHas('item', ['id' => $item->id, 'name' => $item->name, 'flag_delete' => false]);

        $response = $this->post(route('order.add_to_cart'), ['item_id' => $item->id]);

        $response->assertSessionMissing('error');
    }

}

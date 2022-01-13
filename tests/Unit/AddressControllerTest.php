<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\User;
use App\Models\City;

use App\Http\Controllers\AddressController;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    /**
     * Testa a função AddressController::listCountryCity()
     * 
     * Se ela não retonar nada, algo não esta certo.
     *
     * @author Gabriel
     */
    public function testListCountryCity()
    {
        // Verifica se a função não retorna nada
        $this->assertNotEmpty(AddressController::listCountryCity(), "A função não retorna nada. Possivelmente a base de dados está vazia.");
    }

    /**
     * Testa a função AddressController::buildSearchAddressQuery()
     * 
     * Se o endereço do address escolhido for diferente do pesquisado na função utilizando exatamente os parametros desse address, então e porque algo esta errado.
     * 
     * @author Gabriel
     */
    public function testBuildSearchAddressQuery() {
        $address = Address::first();

        $this->assertEquals($address->address, 
                            AddressController::buildSearchAddressQuery($address->user_id, ["address"], $address->flag_active)->first()->address,
                            "A função AddressController::buildSearchAddressQuery não está a funcionar corretamente!");
    }

    /**
     * Testa a função AddressController::desactivateAddress()
     * 
     * Se o novo endereço com flag_ative = true ao ser desativado continuar com o flag_active a true, o teste falha
     * 
     * @author Gabriel
     */
    public function testDesactivateAddress() {
        // Cria um novo address, com a flag_active igual a true
        $address = Address::factory()->create();
        $address->flag_active = true;

        // Desativa o address
        AddressController::desactivateAddress($address->id);

        // Atualiza o address com os novos valores
        $address = Address::find($address->id);

        // Testa se o address foi desativado
        $this->assertFalse($address->flag_active);

        // Elimina o address criado para o teste
        Address::find($address->id)->delete();
    }

    /**
     * Testa a função AddressController::activateAddress()
     * 
     * Se o novo endereço com flag_ative = false ao ser ativado continuar com o flag_active a false, o teste falha
     * 
     * @author Gabriel
     */
    public function testActivateAddress() {
        // Cria um novo address, com a flag_active igual a false
        $address = Address::factory()->create();
        $address->flag_active = false;

        // Ativa o address
        AddressController::activateAddress($address->id);

        // Atualiza o address com os novos valores
        $address = Address::find($address->id);

        // Testa se o address foi desativado
        $this->assertTrue($address->flag_active);

        // Elimina o address criado para o teste
        Address::find($address->id)->delete();
    }

    /**
     * Testa a função AddressController::deleteAddress()
     * 
     * Se o novo endereço com flag_delete = false ao ser eliminado continuar com o flag_delete a false, o teste falha
     * 
     * @author Gabriel
     */
    public function testDeleteAddress() {
        // Cria um novo address, com a flag_delete igual a false
        $address = Address::factory()->create();
        $address->flag_delete = false;

        // Elimina o address
        AddressController::deleteAddress($address->id);

        // Atualiza o address com os novos valores
        $address = Address::find($address->id);

        // Testa se o address foi eliminado
        $this->assertTrue($address->flag_delete);

        // Elimina(da base de dados mesmo) o address criado para o teste
        Address::find($address->id)->delete();
    }

    /**
     * Testa a função AddressController::createAddressController()
     * 
     * Se o address que pretendemos criar não existir o teste falha
     * 
     * @author Gabriel
     */
    public function testCreateAddress() {
        $city_id = City::first()->id;
        $address = "blablabla";

        // Criamos um utilizador novo, para ter a certeza que não possui qualquer endereço
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->withSession(['email' =>  $user->email, 'password' => 'password'])
                         ->post(route("createAddress"), ['city' => $city_id, 'address' => $address]);



        // Testamos se o endereço foi criado
        $newAddress = Address::where('user_id','=',$user->id)->first();
        $this->assertNotNull($newAddress, "O endereço não foi criado. Ha um problema com a AddressController::createAddress()");

        // Eliminamos o address e o user criados
        Address::find($newAddress->id)->delete();
        User::find($user->id)->delete();
    }
}

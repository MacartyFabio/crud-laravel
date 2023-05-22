<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a listagem de pedidos.
     *
     * @return void
     */
    public function testOrderIndex()
    {
        $response = $this->get('/orders');

        $response->assertStatus(200);
        $response->assertViewIs('orders.index');
    }

    /**
     * Testa a criação de um novo pedido.
     *
     * @return void
     */
    public function testOrderCreate()
    {
        $response = $this->get('/orders/create');

        $response->assertStatus(200);
        $response->assertViewIs('orders.create');
    }

    /**
     * Testa o armazenamento de um novo pedido.
     *
     * @return void
     */
    public function testOrderStore()
    {
        $data = [
            'delivery_date' => '2023-05-21',
            'freight_value' => 100.50,
        ];

        $response = $this->post('/orders', $data);

        $response->assertStatus(302);
        $response->assertRedirect('/orders');
        $this->assertDatabaseHas('orders', $data);
    }

    /**
     * Testa a exibição de um pedido específico.
     *
     * @return void
     */
    public function testOrderShow()
    {
        $order = Order::factory()->create();

        $response = $this->get('/orders/' . $order->id);

        $response->assertStatus(200);
        $response->assertViewIs('orders.show');
        $response->assertViewHas('order', $order);
    }

    /**
     * Testa a edição de um pedido.
     *
     * @return void
     */
    public function testOrderEdit()
    {
        $order = Order::factory()->create();

        $response = $this->get('/orders/' . $order->id . '/edit');

        $response->assertStatus(200);
        $response->assertViewIs('orders.edit');
        $response->assertViewHas('order', $order);
    }

    /**
     * Testa a atualização de um pedido.
     *
     * @return void
     */
    public function testOrderUpdate()
    {
        $order = Order::factory()->create();

        $data = [
            'delivery_date' => '2023-05-22',
            'freight_value' => 150.75,
        ];

        $response = $this->put('/orders/' . $order->id, $data);

        $response->assertStatus(302);
        $response->assertRedirect('/orders');
        $this->assertDatabaseHas('orders', $data);
    }

    /**
     * Testa a exclusão de um pedido.
     *
     * @return void
     */
    public function testOrderDestroy()
    {
        $order = Order::factory()->create();

        $response = $this->delete('/orders/' . $order->id);

        $response->assertStatus(302);
        $response->assertRedirect('/orders');
        $this->assertDeleted($order);
    }
}

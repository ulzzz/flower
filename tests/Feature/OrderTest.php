<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_it_can_fetch_all_orders()
    {
        Order::factory(10)->create();

        $response = $this->getJson('/api/orders');

        $response->assertOk();
        $response->assertJsonCount(10);
    }

    public function test_it_can_create_an_order()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $data = [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'price' => 150.00,
        ];

        $response = $this->postJson('/api/orders', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', $data);
    }

    public function test_it_can_show_a_single_order()
    {
        $order = Order::factory()->create();

        $response = $this->getJson("/api/orders/{$order->id}");

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $order->id,
            'price' => (string)$order->price,
        ]);
    }

    public function test_it_can_update_an_order()
    {
        $order = Order::factory()->create();

        $data = [
            'price' => 200.00,
        ];

        $response = $this->putJson("/api/orders/{$order->id}", $data);

        $response->assertOk();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'price' => 200.00,
        ]);
    }

    public function test_it_can_delete_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        return $this->actingAs($user);
    }

    public function test_can_list_products()
    {
        Product::factory()->count(3)->create();
        $response = $this->authenticate()->getJson('/api/products');
        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_create_product()
    {
        $data = [
            'title' => 'Produto Teste',
            'sale_price' => 120.00,
            'cost' => 100.00,
            'description' => '<p>Descrição do produto</p>',
            'images' => ['https://example.com/image1.jpg', 'https://example.com/image2.png'],
        ];

        $response = $this->authenticate()->postJson('/api/products', $data);
        $response->assertStatus(201)->assertJsonFragment(['title' => 'Produto Teste']);
    }

    public function test_cannot_create_product_with_invalid_price()
    {
        $data = [
            'title' => 'Produto Inválido',
            'sale_price' => 105.0, // Menor que o custo + 10%
            'cost' => 100.0,
            'description' => '<p>Descrição válida</p>',
            'images' => ['image.jpg']
        ];

        $response = $this->authenticate()->postJson('/api/products', $data);
        $response->assertStatus(400);
    }

    public function test_can_update_product()
    {
        $product = Product::factory()->create();
        $data = [
            'title' => 'Produto Atualizado',
            'sale_price' => 130.00,
            'cost' => 110.00,
            'description' => '<p>Descrição atualizada</p>',
            'images' => ['https://example.com/image3.jpg'],
        ];

        $response = $this->authenticate()->putJson("/api/products/{$product->id}", $data);
        $response->assertStatus(200)->assertJsonFragment(['title' => 'Produto Atualizado']);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();
        $response = $this->authenticate()->deleteJson("/api/products/{$product->id}");
        $response->assertStatus(204);
    }
}

<?php

namespace Tests\Feature\Product;

use Domain\Category\Models\Category;
use Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_product(): void
    {
        Permission::create(['name' => 'manage products']);

        $category = Category::factory()->create();
        $user = User::factory()->create();
        $user->givePermissionTo(['manage products']);

        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this
            ->actingAs($user)
            ->postJson('/api/products', [
                'name' => 'Product',
                'slug' => 'product',
                'category_id' => $category->id,
                'price' => 100
            ], [
                'Authorization' => 'Bearer '.$token,
            ]);

        $response->assertCreated();
    }

    public function test_user_can_not_create_product(): void
    {
        Permission::create(['name' => 'manage products']);
        $category = Category::factory()->create();
        $user = User::factory()->create();

        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this
            ->actingAs($user)
            ->postJson('/api/products', [
                'name' => 'Product',
                'slug' => 'product',
                'category_id' => $category->id,
                'price' => 100
            ], [
                'Authorization' => 'Bearer '.$token,
            ]);

        $response->assertForbidden();
    }
}

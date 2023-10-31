<?php

namespace Tests\Feature\Category;

use Domain\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_category(): void
    {
        Permission::create(['name' => 'manage categories']);
        $user = User::factory()->create();
        $user->givePermissionTo(['manage categories']);

        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this
            ->actingAs($user)
            ->postJson('/api/categories', [
                'name' => 'Category',
                'slug' => 'category',
            ], [
                'Authorization' => 'Bearer '.$token,
            ]);

        $response->assertCreated();
    }

    public function test_user_can_not_create_category(): void
    {
        Permission::create(['name' => 'manage categories']);
        $user = User::factory()->create();

        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this
            ->actingAs($user)
            ->postJson('/api/categories', [
                'name' => 'Category',
                'slug' => 'category',
            ], [
                'Authorization' => 'Bearer '.$token,
            ]);

        $response->assertForbidden();
    }
}

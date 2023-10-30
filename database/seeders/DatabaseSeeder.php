<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Domain\Category\Models\Category;
use Domain\Product\Models\Product;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'create products',
            'view products',
            'update products',
            'delete products',
            'create categories',
            'view categories',
            'update categories',
            'delete categories',
            'create users',
            'view users',
            'update users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $user->givePermissionTo($permissions);

        Category::factory(10)
            ->has(Product::factory()->count(10))
            ->create();
    }
}

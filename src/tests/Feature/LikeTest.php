<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStatus;
use App\Models\Like;

class LikeTest extends TestCase
{
    public function test_product_registered_as_a_liked_product_and_the_total_number_of_likes_are_displayed_as_increased()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        $product = Product::create([
            'user_id' => $seller->id,
            'product_status_id' => $status->id,
            'name' => '腕時計',
            'brand_name' => 'ブランド',
            'price' => 2000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);
        $this->actingAs($user);
        $response = $this->post("/product/{$product->id}/like");

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('1');
    }

    public function test_the_color_changes_when_the_Like_icon_is_pressed()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        $product = Product::create([
            'user_id' => $seller->id,
            'product_status_id' => $status->id,
            'name' => '腕時計',
            'brand_name' => 'ブランド',
            'price' => 2000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);
        $this->actingAs($user);
        $response = $this->post("/product/{$product->id}/like");

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('images/ハートロゴ_ピンク.png');
    }

    public function test_test_product_like_can_be_removed_by_pressing_icon_again()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        $product = Product::create([
            'user_id' => $seller->id,
            'product_status_id' => $status->id,
            'name' => '腕時計',
            'brand_name' => 'ブランド',
            'price' => 2000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        $this->actingAs($user);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->post("/product/{$product->id}/unlike");
        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('images/ハートロゴ_デフォルト.png');
    }
    
}

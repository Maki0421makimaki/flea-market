<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStatus;
use App\Models\Profile;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_purchase_products()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        Profile::create([
            'user_id' => $user->id,
            'name' => 'コメント太郎',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
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
        $response = $this->post("/purchase/{$product->id}", ['payment_method' => 'card']);

        $response->assertStatus(302);

        $response = $this->get("/purchase/success/{$product->id}");
        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_purchased_product_is_marked_as_sold()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        Profile::create([
            'user_id' => $user->id,
            'name' => 'コメント太郎',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
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
        $response = $this->post("/purchase/{$product->id}", ['payment_method' => 'card']);

        $response->assertStatus(302);

        $response = $this->get("/purchase/success/{$product->id}");
        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $response = $this->get("/");
        $response->assertStatus(200);
        $response->assertSee('sold');
    }

    public function test_purchased_product_is_added_to_the_list_of_purchased()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        Profile::create([
            'user_id' => $user->id,
            'name' => 'コメント太郎',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
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
        $response = $this->post("/purchase/{$product->id}", ['payment_method' => 'card']);

        $response->assertStatus(302);

        $response = $this->get("/purchase/success/{$product->id}");
        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $response = $this->get("/mypage?page=buy");
        $response->assertStatus(200);
        $response->assertSee('腕時計');
    }

    public function test_registered_address_will_be_correctly_reflected_on_the_product_purchase_screen()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        Profile::create([
            'user_id' => $user->id,
            'name' => 'コメント太郎',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
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
        $response = $this->get("/purchase/address/{$product->id}");

        $response = $this->post("/purchase/address/{$product->id}", [
            'post_code' => '111-1234',
            'address' => '京都府',
            'building' => 'テストマンション',
        ]);

        $response->assertStatus(302);

        $response = $this->get("/purchase/{$product->id}");
        $response->assertStatus(200);

        $response->assertSee('111-1234');
        $response->assertSee('京都府');
        $response->assertSee('テストマンション');
    }
    public function test_shipping_address_is_registered_and_linked_to_the_purchased_product()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        Profile::create([
            'user_id' => $user->id,
            'name' => 'コメント太郎',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
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

        $response = $this->post("/purchase/address/{$product->id}", [
            'post_code' => '111-1234',
            'address' => '京都府',
            'building' => 'テストマンション',
        ]);

        $response->assertStatus(302);

        $response = $this->get("/purchase/{$product->id}");
        $response->assertStatus(200);

        $response = $this->post("/purchase/{$product->id}", ['payment_method' => 'card']);

        $response->assertStatus(302);

        $response = $this->get("/purchase/success/{$product->id}");
        $response->assertStatus(302);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'post_code' => '111-1234',
            'address' => '京都府',
            'building' => 'テストマンション',
        ]);
    }


}

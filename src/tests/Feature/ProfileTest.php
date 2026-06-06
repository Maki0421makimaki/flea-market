<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStatus;
use App\Models\Purchase;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    public function test_user_profile_information_is_displayed()
    {
        $user = User::factory()->create();

        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        $myProduct = Product::create([
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => '出品した腕時計',
            'brand_name' => 'ブランドA',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/sell.jpg',
        ]);

        $otherUser = User::factory()->create();
        $boughtProduct = Product::create([
            'user_id' => $otherUser->id,
            'product_status_id' => $status->id,
            'name' => '購入したスニーカー',
            'brand_name' => 'ブランドB',
            'price' => 5000,
            'description' => '説明',
            'image' => 'images/products/buy.jpg',
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'name' => 'テスト太郎',
            'image' => 'test_user.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $boughtProduct->id,
        ]);

        $response = $this->actingAs($user)->get('mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee($profile->name);
        $response->assertSee($profile->image);
        $response->assertSee($boughtProduct->name);
        $response->assertDontSee($myProduct->name);

        $response = $this->actingAs($user)->get('mypage?page=sell');

        $response->assertStatus(200);
        $response->assertSee($profile->name);
        $response->assertSee($profile->image);
        $response->assertSee($myProduct->name);
        $response->assertDontSee($boughtProduct->name);
    }

    public function test_default_values_for_each_item_in_the_user_profile_are_displayed_correctly()
    {
        $user = User::factory()->create();

        $profile = Profile::create([
            'user_id' => $user->id,
            'name' => 'テスト太郎',
            'image' => 'test_user.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)->get('mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('value="テスト太郎"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都"', false);
        $response->assertSee('value="テストビル"', false);
        $response->assertSee($profile->image);
    }

}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStatus;
use App\Models\Purchase;
use App\Models\Profile;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_products_are_displayed()
    {
        $user = User::factory()->create();
        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        Product::create([
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 1000,
            'description' => 'テスト説明',
            'image' => 'images/products/test.jpg',
            'product_status_id' => $status->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    public function test_sold_label_is_displayed_on_purchased_product()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'product_status_id' => $status->id,
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'price' => 1000,
            'description' => 'テスト説明',
            'image' => 'images/products/test.jpg',
        ]);

        Purchase::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);

        Profile::create([
            'user_id' => $buyer->id,
            'name' => 'テストユーザー',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($buyer)
            ->get('/');

        $response->assertStatus(200);
        $response->assertSee('sold');
    }


    public function test_user_products_are_not_displayed_on_recommend_page()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        Profile::create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        Product::create([
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => '自分の商品',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        Product::create([
            'user_id' => $otherUser->id,
            'product_status_id' => $status->id,
            'name' => '他人の商品',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }

    public function test_liked_products_are_displayed_in_mylist()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $otherUser = User::factory()->create(['email_verified_at' => now()]);

        Profile::create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        $likedProduct = Product::create([
            'user_id' => $otherUser->id,
            'product_status_id' => $status->id,
            'name' => 'いいねした商品',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        $notLikedProduct = Product::create([
            'user_id' => $otherUser->id,
            'product_status_id' => $status->id,
            'name' => 'いいねしていない商品',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $likedProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    public function test_sold_label_is_displayed_on_purchased_product_in_mylist()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        Profile::create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        $product = Product::create([
            'user_id' => $seller->id,
            'product_status_id' => $status->id,
            'name' => '購入済み商品',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('購入済み商品');
        $response->assertSee('sold');
    }


    public function test_guest_cannot_access_mylist()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertDontSee('テスト商品');
    }

    public function test_products_can_be_searched_by_partial_name()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        Product::create([
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => '腕時計',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        Product::create([
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => 'Tシャツ',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        $response = $this->get('/?keyword=腕');

        $response->assertStatus(200);

        $response->assertSee('腕時計');
        $response->assertDontSee('Tシャツ');
    }

    public function test_search_keyword_is_kept_when_switching_to_mylist()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($user)
            ->get('/?keyword=時計');

        $response->assertStatus(200);
        $response->assertSee('時計');

        $response = $this->actingAs($user)
            ->get('/?tab=mylist&keyword=時計');

        $response->assertStatus(200);
        $response->assertSee('value="時計"', false);
    }

    public function test_all_product_information_are_displayed()
    {
        $user = User::factory()->create();
        $status = ProductStatus::create([
            'name' => '良好',
        ]);
        $commentUser = User::factory()->create(['name' => 'コメント太郎']);

        $product = Product::create([
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => '腕時計',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        Profile::create([
            'user_id' => $commentUser->id,
            'name' => 'コメント太郎',
            'image' => 'test.jpg',
            'post_code' => '123-4567',
            'address' => '東京都',
            'building' => 'テストビル',
        ]);

        Comment::create([
            'product_id' => $product->id,
            'user_id' => $commentUser->id,
            'comment' => '商品の状態を詳しく教えてください',
        ]);

        Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('良好');
        $response->assertSee('腕時計', );
        $response->assertSee('ブランド');
        $response->assertSee('1000');
        $response->assertSee('説明');
        $response->assertSee('images/products/test.jpg');
        $response->assertSee('コメント太郎');
        $response->assertSee('商品の状態を詳しく教えてください');
        $response->assertSee('コメント(1)');
    }

    public function test_multiple_selected_categories_are_displayed()
    {
        $user = User::factory()->create();
        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        $category1 = Category::create([
            'name' => 'メンズ',
        ]);

        $category2 = Category::create([
            'name' => 'ファッション',
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => '腕時計',
            'brand_name' => 'ブランド',
            'price' => 1000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        $product->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('メンズ');
        $response->assertSee('ファッション' );
    }

    public function test_product_can_be_saved_with_required_information()
    {
        $user = User::factory()->create();

        $category = Category::create(['name' => 'メンズ']);
        $status = ProductStatus::create(['name' => '良好']);
        $dummyImage = UploadedFile::fake()->create('product_test.jpg', 100);
        $postData = [
            'categories' => $category->id,
            'product_status_id' => $status->id,
            'name' => 'テスト商品名',
            'brand_name' => 'テストブランド',
            'description' => 'これは商品の説明文です。',
            'price' => 2500,
            'image' => $dummyImage,
        ];

        $response = $this->actingAs($user)->post('sell', $postData);

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => 'テスト商品名',
            'brand_name' => 'テストブランド',
            'description' => 'これは商品の説明文です。',
            'price' => 2500,
        ]);

        $product = Product::latest()->first();

        Storage::disk('public')->assertExists($product->image);

    }

}

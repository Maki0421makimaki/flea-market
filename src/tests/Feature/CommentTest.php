<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStatus;
use App\Models\Profile;


class CommentTest extends TestCase
{
    public function test_comments_are_saved_and_the_number_of_comments_increases()
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
        $response = $this->post("/product/{$product->id}/comment", ['comment' => 'テストコメントです！']);

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('コメント(1)');
        $response->assertSee('テストコメントです！');
    }

    public function test_guest_cannot_post_comment()
    {
        $user = User::factory()->create();
        $status = ProductStatus::create([
            'name' => '良好',
        ]);

        $product = Product::create([
            'user_id' => $user->id,
            'product_status_id' => $status->id,
            'name' => '腕時計',
            'brand_name' => 'ブランド',
            'price' => 2000,
            'description' => '説明',
            'image' => 'images/products/test.jpg',
        ]);

        $response = $this->post("/product/{$product->id}/comment", ['comment' => 'テストコメントです！']);
        $response->assertStatus(302);
        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertDontSee('テストコメントです！');
    }


    public function test_if_no_comment_is_entered_a_validation_message_will_be_displayed()
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
        $response = $this->post("/product/{$product->id}/comment", ['comment' => '']);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['comment']);

        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('コメントを入力してください');
    }

    public function test_if_the_comment_is_longer_than_255_characters_a_validation_message_will_be_displayed()
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
        $response = $this->post("/product/{$product->id}/comment", ['comment' => 'システムテスト用のダミーコメントです。この文章は文字数制限のバリデーションチェックを目的として作成されています。文字数が仕様の限界を超えた際のシステムの挙動を確認するために、意図的に２５５文字以上の長さに調整しています。エラー画面が正しく表示されるか、または入力制限がかかるかを確認してください。テストを円滑に進めるため、特別な意味を持たない一般的な日本語の表現のみを使用しています。このまま入力フォームにコピー＆ペーストして、バリデーション機能が正しく動作するかどうかを詳細に検証してください。２６０文字のテスト完了。']);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['comment']);

        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('コメントは255文字以下にしてください');
    }


}

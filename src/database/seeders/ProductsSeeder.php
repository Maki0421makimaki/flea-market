<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'テスト管理者',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);


        $param = [
            [
                'user_id' => $user->id,
                'name' => '腕時計',
                'price' => 15000,
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image' => 'products/Armani+Mens+Clock.jpg',
                'product_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'HDD',
                'price' => 5000,
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'image' => 'products/HDD+Hard+Disk.jpg',
                'product_status_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand_name' => 'なし',
                'description' => '新鮮な玉ねぎ3束セット',
                'image' => 'products/iLoveIMG+d.jpg',
                'product_status_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => '革靴',
                'price' => 4000,
                'brand_name' => '',
                'description' => 'クラシックなデザインの革靴',
                'image' => 'products/Leather+Shoes+Product+Photo.jpg',
                'product_status_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'ノートPC',
                'price' => 45000,
                'brand_name' => '',
                'description' => '高性能なノートパソコン',
                'image' => 'products/Living+Room+Laptop.jpg',
                'product_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'マイク',
                'price' => 8000,
                'brand_name' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'image' => 'products/Music+Mic+4632231.jpg',
                'product_status_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand_name' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'image' => 'products/Purse+fashion+pocket.jpg',
                'product_status_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'タンブラー',
                'price' => 500,
                'brand_name' => 'なし',
                'description' => '使いやすいタンブラー',
                'image' => 'products/Tumbler+souvenir.jpg',
                'product_status_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'image' => 'products/Waitress+with+Coffee+Grinder.jpg',
                'product_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'name' => 'メイクセット',
                'price' => 2500,
                'brand_name' => '',
                'description' => '便利なメイクアップセット',
                'image' => 'products/外出メイクアップセット.jpg',
                'product_status_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('products')->insert($param);
    }
}



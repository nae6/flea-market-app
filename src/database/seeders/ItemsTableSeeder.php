<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'item_name' => '腕時計',
                'image_url' => '/storage/images/watch.jpg',
                'brand' => 'Rolax',
                'price' => 15,000,
                'condition' => 1,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'HDD',
                'image_url' => '/storage/images/hdd.jpg',
                'brand' => '西芝',
                'price' => 5,000,
                'condition' => 2,
                'description' => '高速で信頼性の高いハードディスク',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => '玉ねぎ3束',
                'image_url' => '/storage/images/onion.jpg',
                'brand' => null,
                'price' => 300,
                'condition' => 3,
                'description' => '新鮮な玉ねぎ3束のセット',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => '革靴',
                'image_url' => '/storage/images/shoes.jpg',
                'brand' => null,
                'price' => 4,000,
                'condition' => 4,
                'description' => 'クラシックなデザインの革靴',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'ノートPC',
                'image_url' => '/storage/images/laptop.jpg',
                'brand' => null,
                'price' => 45,000,
                'condition' => 1, // 良好
                'description' => '高性能なノートパソコン',
                'status' => 2,
                'user_id' => 2,
            ],
            [
                'item_name' => 'マイク',
                'image_url' => '/storage/images/mic.jpg',
                'brand' => null,
                'price' => 8,000,
                'condition' => 2,
                'description' => '高音質のレコーディング用マイク',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'ショルダーバッグ',
                'image_url' => '/storage/images/bag.jpg',
                'brand' => null,
                'price' => 3,500,
                'condition' => 3,
                'description' => 'おしゃれなショルダーバッグ',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'タンブラー',
                'image_url' => '/storage/images/tumbler.jpg',
                'brand' => null,
                'price' => 500,
                'condition' => 4,
                'description' => '使いやすいタンブラー',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'コーヒーミル',
                'image_url' => '/storage/images/mill.jpg',
                'brand' => 'Starbacks',
                'price' => 4,000,
                'condition' => 1,
                'description' => '手動のコーヒーミル',
                'status' => 1,
                'user_id' => 1,
            ],
            [
                'item_name' => 'メイクセット',
                'image_url' => '/storage/images/makeup.jpg',
                'brand' => null,
                'price' => 2,500,
                'condition' => 2,
                'description' => '便利なメイクアップセット',
                'status' => 1,
                'user_id' => 1,
            ],
        ];

        foreach ($items as $item)
        {
            Item::create($item);
        }
    }
}

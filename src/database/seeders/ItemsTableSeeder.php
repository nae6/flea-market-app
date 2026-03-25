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
                'image_url' => 'sample-images/watch.jpg',
                'brand' => 'Rolax',
                'price' => 15000,
                'condition_id' => 1,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'HDD',
                'image_url' => 'sample-images/hdd.jpg',
                'brand' => '西芝',
                'price' => 5000,
                'condition_id' => 2,
                'description' => '高速で信頼性の高いハードディスク',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => '玉ねぎ3束',
                'image_url' => 'sample-images/onion.jpg',
                'brand' => null,
                'price' => 300,
                'condition_id' => 3,
                'description' => '新鮮な玉ねぎ3束のセット',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => '革靴',
                'image_url' => 'sample-images/shoes.jpg',
                'brand' => null,
                'price' => 4000,
                'condition_id' => 4,
                'description' => 'クラシックなデザインの革靴',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'ノートPC',
                'image_url' => 'sample-images/laptop.jpg',
                'brand' => null,
                'price' => 45000,
                'condition_id' => 1,
                'description' => '高性能なノートパソコン',
                'status' => 2,
                'user_id' => 2,
            ],
            [
                'item_name' => 'マイク',
                'image_url' => 'sample-images/mic.jpg',
                'brand' => null,
                'price' => 8000,
                'condition_id' => 2,
                'description' => '高音質のレコーディング用マイク',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'ショルダーバッグ',
                'image_url' => 'sample-images/bag.jpg',
                'brand' => null,
                'price' => 3500,
                'condition_id' => 3,
                'description' => 'おしゃれなショルダーバッグ',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'タンブラー',
                'image_url' => 'sample-images/tumbler.jpg',
                'brand' => null,
                'price' => 500,
                'condition_id' => 4,
                'description' => '使いやすいタンブラー',
                'status' => 1,
                'user_id' => 2,
            ],
            [
                'item_name' => 'コーヒーミル',
                'image_url' => 'sample-images/mill.jpg',
                'brand' => 'Starbacks',
                'price' => 4000,
                'condition_id' => 1,
                'description' => '手動のコーヒーミル',
                'status' => 1,
                'user_id' => 1,
            ],
            [
                'item_name' => 'メイクセット',
                'image_url' => 'sample-images/makeup.jpg',
                'brand' => null,
                'price' => 2500,
                'condition_id' => 2,
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

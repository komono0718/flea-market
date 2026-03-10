<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'img_url' => 'items/watch.jpg',
                'condition' => '良好',
                'user_id' => 1,
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'img_url' => 'items/HDD.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 1,
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'img_url' => 'items/onion.jpg',
                'condition' => 'やや傷や汚れあり',
                'user_id' => 1,
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand' => null,
                'description' => 'クラシックなデザインの革靴',
                'img_url' => 'items/shoes.jpg',
                'condition' => '状態が悪い',
                'user_id' => 1,
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => null,
                'description' => '高性能なノートパソコン',
                'img_url' => 'items/pc.jpg',
                'condition' => '良好',
                'user_id' => 1,
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand' => null,
                'description' => '高音質のレコーディング用マイク',
                'img_url' => 'items/mic.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 1,
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'img_url' => 'items/bag.jpg',
                'condition' => 'やや傷や汚れあり',
                'user_id' => 1,
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => null,
                'description' => '使いやすいタンブラー',
                'img_url' => 'items/tumbler.jpg',
                'condition' => '状態が悪い',
                'user_id' => 1,
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'img_url' => 'items/mill.jpg',
                'condition' => '良好',
                'user_id' => 1,
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => null,
                'description' => '便利なメイクアップセット',
                'img_url' => 'items/makeup.jpg',
                'condition' => '目立った傷や汚れなし',
                'user_id' => 1,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}

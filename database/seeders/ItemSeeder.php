<?php

namespace Database\Seeders;

use App\Condition;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'image_name'  => 'Armani-Mens-Clock.jpg',
                'condition'   => Condition::LikeNew,
                'name'        => '腕時計',
                'brand_name'  => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price'       => 15000,
            ],
            [
                'image_name'  => 'HDD-Hard-Disk.jpg',
                'condition'   => Condition::Good,
                'name'        => 'HDD',
                'brand_name'  => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price'       => 5000,
            ],
            [
                'image_name'  => 'iLoveIMG-d.jpg',
                'condition'   => Condition::Fair,
                'name'        => '玉ねぎ3束',
                'brand_name'  => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price'       => 300,
            ],
            [
                'image_name'  => 'Leather-Shoes-Product-Photo.jpg',
                'condition'   => Condition::Bad,
                'name'        => '革靴',
                'brand_name'  => '',
                'description' => 'クラシックなデザインの革靴',
                'price'       => 4000,
            ],
            [
                'image_name'  => 'Living-Room-Laptop.jpg',
                'condition'   => Condition::LikeNew,
                'name'        => 'ノートPC',
                'brand_name'  => '',
                'description' => '高性能なノートパソコン',
                'price'       => 45000,
            ],
            [
                'image_name'  => 'Music-Mic-4632231.jpg',
                'condition'   => Condition::Good,
                'name'        => 'マイク',
                'brand_name'  => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price'       => 8000,
            ],
            [
                'image_name'  => 'Purse-fashion-pocket.jpg',
                'condition'   => Condition::Fair,
                'name'        => 'ショルダーバッグ',
                'brand_name'  => '',
                'description' => 'おしゃれなショルダーバッグ',
                'price'       => 3500,
            ],
            [
                'image_name'  => 'Tumbler-souvenir.jpg',
                'condition'   => Condition::Bad,
                'name'        => 'タンブラー',
                'brand_name'  => 'なし',
                'description' => '使いやすいタンブラー',
                'price'       => 500,
            ],
            [
                'image_name'  => 'Waitress-with-Coffee-Grinder.jpg',
                'condition'   => Condition::LikeNew,
                'name'        => 'コーヒーミル',
                'brand_name'  => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price'       => 4000,
            ],
            [
                'image_name'  => 'makeup-set.jpg',
                'condition'   => Condition::Good,
                'name'        => 'メイクセット',
                'brand_name'  => '',
                'description' => '便利なメイクアップセット',
                'price'       => 2500,
            ],
        ];

        $this->seedItems($items);
    }

    protected function seedItems(array $items): void
    {
        Storage::disk('public')->deleteDirectory('items');
        Storage::disk('public')->makeDirectory('items');

        foreach ($items as $item) {
            $imageName   = $item['image_name'] ?? 'default.jpg';
            $sourcePath  = database_path("seeders/images/{$imageName}");
            $storagePath = "items/{$imageName}";

            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($storagePath, File::get($sourcePath));
            }

            Item::factory()->recycle(User::all())->create([
                'image_path'  => $storagePath,
                'condition'   => $item['condition'],
                'name'        => $item['name'],
                'brand_name'  => $item['brand_name'],
                'description' => $item['description'],
                'price'       => $item['price'],
            ]);
        }
    }
}

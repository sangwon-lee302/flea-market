<?php

namespace Database\Seeders;

use App\Category as CategoryEnum;
use App\Condition;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Database\Seeders\Traits\HasImageSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    use HasImageSeeder;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fashion     = Category::where('name', CategoryEnum::Fashion->value)->first();
        $electronics = Category::where('name', CategoryEnum::Electronics->value)->first();
        $womens      = Category::where('name', CategoryEnum::Womens->value)->first();
        $mens        = Category::where('name', CategoryEnum::Mens->value)->first();
        $cosmetics   = Category::where('name', CategoryEnum::Cosmetics->value)->first();
        $kitchen     = Category::where('name', CategoryEnum::Kitchen->value)->first();
        $accessories = Category::where('name', CategoryEnum::Accessories->value)->first();

        $items = [
            [
                'image_name'  => 'Armani-Mens-Clock.jpg',
                'condition'   => Condition::LikeNew,
                'name'        => '腕時計',
                'brand_name'  => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price'       => 15000,
                'categories'  => [$fashion, $mens, $accessories],
            ],
            [
                'image_name'  => 'HDD-Hard-Disk.jpg',
                'condition'   => Condition::Good,
                'name'        => 'HDD',
                'brand_name'  => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price'       => 5000,
                'categories'  => [$electronics],
            ],
            [
                'image_name'  => 'iLoveIMG-d.jpg',
                'condition'   => Condition::Fair,
                'name'        => '玉ねぎ3束',
                'brand_name'  => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price'       => 300,
                'categories'  => [$kitchen],
            ],
            [
                'image_name'  => 'Leather-Shoes-Product-Photo.jpg',
                'condition'   => Condition::Bad,
                'name'        => '革靴',
                'brand_name'  => '',
                'description' => 'クラシックなデザインの革靴',
                'price'       => 4000,
                'categories'  => [$fashion, $mens],
            ],
            [
                'image_name'  => 'Living-Room-Laptop.jpg',
                'condition'   => Condition::LikeNew,
                'name'        => 'ノートPC',
                'brand_name'  => '',
                'description' => '高性能なノートパソコン',
                'price'       => 45000,
                'categories'  => [$electronics],
            ],
            [
                'image_name'  => 'Music-Mic-4632231.jpg',
                'condition'   => Condition::Good,
                'name'        => 'マイク',
                'brand_name'  => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price'       => 8000,
                'categories'  => [$electronics],
            ],
            [
                'image_name'  => 'Purse-fashion-pocket.jpg',
                'condition'   => Condition::Fair,
                'name'        => 'ショルダーバッグ',
                'brand_name'  => '',
                'description' => 'おしゃれなショルダーバッグ',
                'price'       => 3500,
                'categories'  => [$fashion, $womens],
            ],
            [
                'image_name'  => 'Tumbler-souvenir.jpg',
                'condition'   => Condition::Bad,
                'name'        => 'タンブラー',
                'brand_name'  => 'なし',
                'description' => '使いやすいタンブラー',
                'price'       => 500,
                'categories'  => [$kitchen],
            ],
            [
                'image_name'  => 'Waitress-with-Coffee-Grinder.jpg',
                'condition'   => Condition::LikeNew,
                'name'        => 'コーヒーミル',
                'brand_name'  => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price'       => 4000,
                'categories'  => [$kitchen],
            ],
            [
                'image_name'  => 'makeup-set.jpg',
                'condition'   => Condition::Good,
                'name'        => 'メイクセット',
                'brand_name'  => '',
                'description' => '便利なメイクアップセット',
                'price'       => 2500,
                'categories'  => [$cosmetics],
            ],
        ];

        $this->seed($items);
    }

    protected function seed(array $items): void
    {
        $subDir = 'images';

        Storage::disk('public')->makeDirectory($subDir);

        $this->copyImageToStorage('default-item-image.jpg', $subDir);

        foreach ($items as $data) {
            $destPath = $this->copyImageToStorage($data['image_name'], $subDir);

            Item::factory()->recycle(User::all())->hasAttached($data['categories'])->create([
                'image'       => $destPath,
                'condition'   => $data['condition'],
                'name'        => $data['name'],
                'brand_name'  => $data['brand_name'],
                'description' => $data['description'],
                'price'       => $data['price'],
            ]);
        }
    }
}

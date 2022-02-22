<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'name' => '道ばた',
            ],
            [
                'id' => 2,
                'name' => '公園',
            ],
            [
                'id' => 3,
                'name' => 'ガーデニング',
            ],
            [
                'id' => 4,
                'name' => '観光地',
            ],
            [
                'id' => 5,
                'name' => '秘密の場所',
            ],
            [
                'id' => 6,
                'name' => 'その他',
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

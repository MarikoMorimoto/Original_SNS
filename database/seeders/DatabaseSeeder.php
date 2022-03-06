<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 作成したSeederクラスを呼び出す この記述がないと、php artisan db:seed しても意味なし。
        $this->call(CategorySeeder::class);
    }
}

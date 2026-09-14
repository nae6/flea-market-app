<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favorites = [
            [
                'user_id' => 1,
                'item_id' => 1,
            ],
            [
                'user_id' => 1,
                'item_id' => 2,
            ],
            [
                'user_id' => 1,
                'item_id' => 7,
            ],
        ];

        DB::table('favorites')->insert($favorites);
    }
}

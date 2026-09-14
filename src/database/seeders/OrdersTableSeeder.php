<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'buyer_id' => 1,
                'item_id' => 6,
                'payment_method' => 'card',
                'stripe_checkout_session_id' => 'cs_test_' . Str::random(24),
                'stripe_payment_intent_id' => 'cs_test_' . Str::random(24),
                'amount' => 8000,
                'zip_code' => '100-0001',
                'address' => '東京都千代田区',
                'building' => 'テストビル101',
                'status' => 'paid',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('orders')->insert($orders);
    }
}

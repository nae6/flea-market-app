<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemPurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザーは購入できる
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * 購入した商品は一覧画面でsoldと表示される
     */

    /**
     * プロフィールの購入した商品一覧に追加されている
     */

    /**
     * 配送先が購入画面に反映されているか
     */
    public function test_shipping_address_is_displayed_on_purchase(): void
    {

    }

    /**
     * 配送先が購入商品と紐づいているか
     */
    public function test_shipping_address_has_relation_to_item(): void
    {

    }
}

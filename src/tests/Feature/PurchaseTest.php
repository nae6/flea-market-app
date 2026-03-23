<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Payments;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザーは購入できる
     */
    public function test_user_can_purchase_item(): void
    {
        
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
     * 小計画面に支払い方法が反映されるか
     * 即時反映されるかは画面で確認する
     */
    public function test_selected_payment_method_is_reflected_in_confirm_area(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'item_name' => 'テスト商品',
            'price' => 12000,
        ]);

        Livewire::actingAs($user)
            ->test(Payments::class, ['item' => $item])
            ->set('selectPayment', 'konbini')
            ->assertSet('selectPayment', 'konbini')
            ->assertSee('コンビニ払い');
    }

    /**
     * 配送先が購入商品と紐づいているか
     */
    public function test_shipping_address_has_relation_to_item(): void
    {

    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\Checkout\Session as CheckoutSession;
use App\Livewire\Payments;
use App\Models\Profile;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Mockery;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザーは購入できる
     * 購入商品にsold表示が出るかは画面で確認する
     * 配送先住所が商品に紐づいているか
     */
    public function test_user_can_purchase_item(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        Profile::factory()->create([
            'user_id' => $buyer->id,
            'zip_code' => '123-4567',
            'address' => '福岡県福岡市博多区呉服町1-1-1',
            'building' => '博多ビル2F',
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'price' => 30000,
            'status' => '1',
        ]);

        $mockSession = (object) [
            'id' => 'cs_test_67890',
            'url' => 'https://checkout.stripe.com/c/pay/cs_test_67890',
        ];

        Mockery::mock('alias:' . CheckoutSession::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn($mockSession);

        $response = $this->actingAs($buyer)
            ->withSession([
                'shipping' => [
                    'zip_code' => '123-4567',
                    'address' => '福岡県福岡市博多区呉服町1-1-1',
                    'building' => '博多ビル2F',
                ],
            ])
            ->post(route('checkout', ['item' => $item->id]), [
                'payment_method' => 'card',
            ]);

        $response->assertRedirect('https://checkout.stripe.com/c/pay/cs_test_67890');

        $this->assertDatabaseHas('orders', [
            'buyer_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method' => 'card',
            'amount' => 30000,
            'zip_code' => '123-4567',
            'address' => '福岡県福岡市博多区呉服町1-1-1',
            'building' => '博多ビル2F',
            'status' => 'pending',
            'stripe_checkout_session_id' => 'cs_test_67890',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'status' => '2',
        ]);
    }

    /**
     * プロフィールの購入した商品一覧に追加されているか
     */
    public function test_boughtItem_add_on_mypage(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'status' => '2',
        ]);

        Order::factory()->create([
            'buyer_id' => $buyer->id,
            'item_id' => $item->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($buyer)
            ->get(route('mypage', ['page' => 'buy']));

        $response->assertOk();
        $response->assertSee($item->item_name);
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
     * 住所変更画面の内容が購入画面の配送先に反映されているか
     */
    public function test_shipping_address_is_displayed_on_purchase(): void
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $addressData = [
            'zip_code' => '123-4567',
            'address' => '福岡県福岡市博多区呉服町1-1-1',
            'building' => '博多ビル2F',
        ];

        $response = $this->actingAs($buyer)
            ->post(route('address.confirm', ['item' => $item->id]), $addressData)
            ->assertRedirect(route('buy', ['item' => $item->id]));

        $response = $this->actingAs($buyer)
            ->get(route('buy', ['item' => $item->id]));

        $response->assertOk();
        $response->assertSee('123-4567');
        $response->assertSee('福岡県福岡市博多区呉服町1-1-1');
        $response->assertSee('博多ビル2F');
    }
}

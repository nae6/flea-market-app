<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Profile;
use App\Models\Order;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * マイページ画面が表示されるか
     * プロフィール画像の表示は画面で確認する
     */
    public function test_mypage_is_displayed(): void
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('mypage'));

        $response->assertOk();
        $response->assertViewIs('dashboard.mypage');
        $response->assertViewHas('profile');
        $response->assertSeeText($profile->user_name);
    }

    /**
     * マイページで出品商品一覧が表示されるか
     */
    public function test_sell_items_are_displayed_on_mypage(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userItem = Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '自分の商品',
        ]);

        $otherItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'item_name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get(route('mypage', ['page' => 'sell']));

        $response->assertOk();
        $response->assertViewIs('dashboard.mypage');
        $response->assertViewHas('activePage', 'sell');

        $response->assertViewHas('items', function($items) use ($userItem, $otherItem) {
            return $items->contains('id', $userItem->id)
                && ! $items->contains('id', $otherItem->id);
        });

        $response->assertSeeText($userItem->item_name);
        $response->assertDontSeeText($otherItem->item_name);
    }

    /**
     * マイページで購入商品一覧が表示されるか
     */
    public function test_buy_items_are_displayed_on_mypage(): void
    {
        $buyer = User::factory()->create();
        $otherUser = User::factory()->create();

        $boughtItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'item_name' => '購入した商品',
        ]);

        $otherItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'item_name' => '購入していない商品',
        ]);

        Order::factory()->create([
            'buyer_id' => $buyer->id,
            'item_id' => $boughtItem->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('mypage', ['page' => 'buy']));

        $response->assertOk();
        $response->assertViewIs('dashboard.mypage');
        $response->assertViewHas('activePage', 'buy');
        $response->assertViewHas('items', function ($items) use ($boughtItem, $otherItem) {
            return $items->contains('id', $boughtItem->id)
                && ! $items->contains('id', $otherItem->id);
        });
        $response->assertSeeText($boughtItem->item_name);
        $response->assertDontSeeText($otherItem->item_name);
    }

    /**
     * プロフィール変更画面に初期値が設定されているか
     * 画像が表示されるかは画面にて確認する
     */
    public function test_old_data_is_displayed_on_profile_edit(): void
    {
        $user = User::factory()->create();
        Profile::factory()->create([
            'user_id' => $user->id,
            'user_name' => '山田花子',
            'zip_code' => '123-4567',
            'address' => '東京都新宿区1-2-3',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertViewIs('dashboard.profile');
        $response->assertViewHas('profile');

        $response->assertSee('value="山田花子"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('value="東京都新宿区1-2-3"', false);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

class MylistViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * いいねした商品が表示されるか
     */
    public function test_favorites_is_displayed_on_mylist(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $favoriteItem = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'いいねした商品',
        ]);
        Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'いいねしていない商品',
        ]);
        $user->favorites()->attach($favoriteItem->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertOk();
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    /**
     * mylistで購入済みはsoldが表示されるか
     * このテストだけでは確定できないため画面確認が必要
     */
    public function test_sold_label_is_displayed_for_sold_item_on_mylist()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $favoriteItem = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => '購入済みいいね商品',
            'status' => '2',
        ]);
        $user->favorites()->attach($favoriteItem->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertOk();
        $response->assertSee('購入済みいいね商品');
        $response->assertSee('class="item__card link__btn sold"', false);
    }

    /**
     * 未認証はマイリストに何も表示されないか
     */
    public function test_guest_user_is_not_displayed_for_items_on_mylist()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $favoriteItem = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'いいね商品',
        ]);

        $user->favorites()->attach($favoriteItem->id);

        $response = $this->get('/?tab=mylist');

        $response->assertOk();
        $response->assertDontSee('いいね商品');
    }
}

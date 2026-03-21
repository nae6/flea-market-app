<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class ItemViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品一覧が表示されるか
     */
    public function test_items_are_displayed(): void
    {
        $items = Item::factory()->count(10)->create();

        $response = $this->get(route('index'));

        $response->assertOk();

        foreach ($items as $item) {
            $response->assertSee($item->item_name);
        }

        $this->assertDatabaseCount('items', 10);
    }

    /**
     * 商品一覧で購入済みはsoldが表示されるか
     * このテストだけでは確定できないため画面確認が必要
     */
    public function test_sold_label_is_displayed_for_sold_item_on_index(): void
    {
        Item::factory()->create([
            'item_name' => '購入済み商品',
            'status' => '2',
        ]);

        $response = $this->get(route('index'));

        $response->assertOk();
        $response->assertSee('購入済み商品');
        $response->assertSee('class="item__card link__btn sold"', false);
    }

    /**
     * ログインユーザーの出品商品は表示されないか
     */
    public function test_authenticated_user_cannot_see_own_items(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        Item::factory()->create([
            'user_id' => $user->id,
            'item_name' => '自分の商品',
        ]);
        Item::factory()->create([
            'user_id' => $otherUser->id,
            'item_name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get(route('index'));

        $response->assertOk();
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }

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
     * マイリストで購入済みはsoldが表示されるか
     * このテストだけでは確定できないため画面確認が必要
     */
    public function test_sold_label_is_displayed_for_sold_item_on_mylist(): void
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
    public function test_guest_user_is_not_displayed_for_items_on_mylist(): void
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

    /**
     * 商品名で部分一致検索ができるか
     */
    public function test_search_returns_items_that_partially_match_keyword(): void
    {
        Item::factory()->create(['item_name' => '赤い服',]);
        Item::factory()->create(['item_name' => '青い服',]);
        Item::factory()->create(['item_name' => 'パソコン',]);

        $response = $this->get('/?keyword=服');

        $response->assertSee('赤い服');
        $response->assertSee('青い服');
        $response->assertDontSee('パソコン');
    }

    /**
     * 検索状態がマイリストに保持されているか
     */
    public function test_mylist_returns_favorite_items_that_match_kyeword(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $redClothes = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => '赤い服',
        ]);

        $blueClothes = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => '青い服',
        ]);

        $pc = Item::factory()->create([
            'user_id' => $seller->id,
            'item_name' => 'パソコン',
        ]);

        $user->favorites()->attach([
            $redClothes->id,
            $blueClothes->id,
            $pc->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=服');

        $response->assertOk();
        $response->assertSee('赤い服');
        $response->assertSee('青い服');
        $response->assertDontSee('パソコン');
        $response->assertSee('value="服"', false);
    }
}

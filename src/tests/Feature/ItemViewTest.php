<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Condition;
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
        $condition = Condition::create(['condition' => '良好',]);

        $items = Item::factory()->count(10)->create([
            'condition_id' => $condition->id,
        ]);

        $response = $this->get(route('index'));

        $response->assertOk();

        foreach ($items as $item) {
            $response->assertSee($item->item_name);
        }

        $this->assertCount(10, Item::all());
    }

    /**
     * soldが表示されるか
     */
    public function test_sold_label_is_displayed_for_sold_item()
    {
        Item::factory()->create([
            'item_name' => '購入済み商品',
            'status' => '2',
        ]);

        $response = $this->get(route('index'));

        $response->assertOk();
        $response->assertSee('購入済み商品');
        $response->assertSee('class="item__card link__btn sold"', false);
        $response->assertSee('SOLD');
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
}

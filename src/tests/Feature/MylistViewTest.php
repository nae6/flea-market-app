<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

class MylistViewTest extends TestCase
{
    use RefreshDatabase;
    /**
     * いいねした商品が表示されるか
     */
    public function test_example(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
    }

    /**
     * mylistで購入済みはsoldが表示されるか
     */
    public function test_sold_label_is_displayed_for_sold_item_on_mylist()
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
     * いいねした商品が表示される
     */
}

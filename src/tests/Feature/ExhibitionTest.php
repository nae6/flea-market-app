<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Condition;
use App\Models\Category;
use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品出品画面が表示されるか
     */
    public function test_sell_page_is_displayed() : void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('sell'));

        $response->assertOk();
    }

    /**
     * 商品の出品ができるか
     */
    public function test_user_can_sell_items(): void
    {
        $user = User::factory()->create();
        $condition = Condition::factory()->create();
        $category = Category::factory()->create();

        $item = [
            'image_url' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
            'categories' => [$category->id],
            'condition_id' => $condition->id,
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => '商品の説明文です',
            'price' => 12000,
        ];

        $response = $this->actingAs($user)->post(route('sell.store'), $item);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('mypage'));

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => '商品の説明文です',
            'price' => 12000,
        ]);

        $createdItem = Item::where('item_name', 'テスト商品')->first();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $createdItem->id,
            'category_id' => $category->id,
        ]);
    }
}

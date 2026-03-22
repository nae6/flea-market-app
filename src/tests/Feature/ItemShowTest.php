<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 商品の詳細情報が全て表示されるか
     * いいね数、コメント数、商品画像は画面で確認が必要
     */
    public function test_item_detail_page_is_displayed(): void
    {
        $seller = User::factory()->create(['name' => '出品者']);
        $commentUser = User::factory()->create(['name' => 'コメントユーザー']);

        $category = Category::factory()->create([
            'category_name' => 'ファッション',
        ]);

        $condition = Condition::factory()->create([
            'condition_name' => '良好',
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'item_name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 12000,
            'description' => '商品の説明文です',
            'image_url' => 'test-image.jpg',
        ]);

        $item->categories()->attach($category->id);

        $comment = Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'content' => 'サイズを教えてください',
        ]);

        $response = $this->get(route('items.show', ['item' => $item->id]));

        $response->assertOk();

        $response->assertSee($item->item_name);
        $response->assertSee($item->brand);
        $response->assertSee(number_format($item->price));
        $response->assertSee($category->category_name);
        $response->assertSee($condition->condition_name);
        $response->assertSee($item->description);
        $response->assertSee($commentUser->name);
        $response->assertSee($comment->content);
    }

    /**
     * 紐づいた複数のカテゴリーが全て表示されるか
     */
    public function test_item_detail_page_displays_all_categories(): void
    {
        $categories = Category::factory()->count(3)->create();
        $item = Item::factory()->create();
        $item->categories()->attach($categories->pluck('id'));

        $response = $this->get(route('items.show', ['item' => $item->id]));

        $response->assertOk();
        foreach ($categories as $category) {
            $response->assertSee($category->category_name);
        }
    }

    /**
     * いいねの登録ができるか
     * 合計数が増加しているかは画面で確認
     */
    public function test_user_can_add_to_item_favorites(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('items.favorite', ['item' => $item->id]));

        $response->assertRedirect();

        $this->assertDatabaseHas('favorites',[
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * いいねの解除ができるか
     * 合計数が減少しているかは画面で確認
     */
    public function test_user_can_remove_item_from_favorites(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $user->favorites()->attach($item->id);

        $this->assertDatabaseHas('favorites', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('items.favorite', ['item' => $item->id]));

        $response->assertRedirect();

        $this->assertDatabaseMissing('favorites', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * コメントが保存されるか
     */
    public function test_user_can_post_comment(): void
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('comments.store', ['item' => $item->id]),
                [
                    'content' => 'サイズを教えてください',
                ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'サイズを教えてください',
        ]);
    }

    /**
     * ゲストユーザーはコメント入力できない
     */
    public function test_guest_cannot_post_comment(): void
    {
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $comment = [
            'content' => '気になります',
        ];

        $response = $this->post(route('comments.store', ['item' => $item->id]), $comment);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'content' => '気になります',
        ]);
    }

    /**
     * コメント入力必須のバリデーション確認
     */
    public function test_comment_is_required(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comments.store', ['item' => $item->id]), ['content' => '']);

        $response->assertSessionHasErrors([
            'content' => 'コメントを入力してください',
        ]);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * コメント文字数255未満のバリデーション確認
     */
    public function test_comment_must_be_within_255_characters(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $content = str_repeat('あ', 256);

        $response = $this->actingAs($user)
            ->post(route('comments.store', ['item' => $item->id]), ['content' => $content]);

        $response->assertSessionHasErrors([
            'content' => '255文字以内で入力してください',
        ]);

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => $content,
        ]);
    }
}
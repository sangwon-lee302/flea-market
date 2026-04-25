<?php

namespace Tests\Feature\Items;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_comment_on_an_item(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create();

        $comment = Comment::factory()->recycle($user)->make();

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('comments.store', $item), ['body' => $comment->body])
            ->assertOk()
            ->assertSeeInOrder([
                'alt="コメント"',
                '<span class="font-semibold">1</span>',
            ], false);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'body'    => $comment->body,
        ]);
    }

    public function test_unauthenticated_user_cannot_comment_on_an_item(): void
    {
        $item = Item::factory()->create();

        $comment = Comment::factory()->make();

        $this->post(route('comments.store', $item), ['body' => $comment->body])
            ->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'body'    => $comment->body,
        ]);
    }

    public function test_user_cannot_comment_with_empty_body(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->get('/item/'.$item->id)->assertOk();

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('comments.store', $item), ['body' => ''])
            ->assertSee('コメントを入力してください');

        $this->assertDatabaseMissing('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'body'    => '',
        ]);
    }

    public function test_user_cannot_comment_with_body_exceeding_max_length(): void
    {
        $user = User::factory()->withProfileCompleted()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)->get('/item/'.$item->id)->assertOk();

        $longBody = str_repeat('a', 256);

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('comments.store', $item), ['body' => $longBody])
            ->assertSee('コメントは255文字以下で入力してください');

        $this->assertDatabaseMissing('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'body'    => $longBody,
        ]);
    }
}

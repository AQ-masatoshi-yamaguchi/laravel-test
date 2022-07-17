<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostListControllerTest extends TestCase
{
    /**  @test */
    function ブログ一覧が表示される()
    {
        $post1 = Post::factory()->hasComments(3)->create();
        $post2 = Post::factory()->hasComments(5)->create();
        Post::factory()->hasComments(1)->create();

        $this->get('/')
            ->assertOk()
            ->assertSee($post1->title)
            ->assertSee($post2->title)
            ->assertSee($post1->user->name)
            ->assertSee($post2->user->name)
            ->assertSee('（3件のコメント）')
            ->assertSee('（5件のコメント）')
            ->assertSeeInOrder([
                '（5件のコメント）',
                '（3件のコメント）',
                '（1件のコメント）',
            ]);
    }

    /**  @test */
    function ブログの一覧で非公開のブログ表示しない()
    {
        $post1 = Post::factory()->closed()->create([
            'title' => 'これは非公開のブログです',
        ]);

        $post2 = Post::factory()->create([
            'title' => 'これは公開のブログです',
        ]);

        $this->get('/')->assertDontSee('これは非公開のブログです')->assertSee('これは公開のブログです');
    }

    /**  @test */
    function factoryのテスト()
    {
        $this->assertTrue(true);
    }
}

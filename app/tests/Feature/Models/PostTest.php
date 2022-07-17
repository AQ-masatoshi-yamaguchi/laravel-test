<?php

namespace Tests\Feature\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**  @test */
    public function userリレーションを返す()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->user);
    }

    /**  @test */
    public function commentsリレーション()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Collection::class, $post->comments);
    }

    /**  @test */
    function ブログ公開非公開(){
        $post1 = Post::factory()->closed()->create();
        $post2 = Post::factory()->create();

        $posts = Post::onlyOpen()->get();

        $this->assertFalse($posts->contains($post1));
        $this->assertTrue($posts->contains($post2));
    }

    /**  @test */
    function ブログで非公開の時はtrueを返し、公開時はfalseを返す(){
        $close = Post::factory()->closed()->create();
        $open = Post::factory()->create();

        $this->assertTrue($close->isClosed());
        $this->assertFalse($open->isClosed());
    }
}

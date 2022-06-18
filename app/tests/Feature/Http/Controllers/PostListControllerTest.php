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
    function ブログ一覧が表示される(){
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();

        $this->get('/')
            ->assertOk()
            ->assertSee($post1->title)
            ->assertSee($post2->title)
            ->assertSee($post1->user->name)
            ->assertSee($post2->user->name);
    }

    /**  @test */
    function test_(){
        $post = Post::factory()->create();

        $this->assertTrue(true);
    }
}

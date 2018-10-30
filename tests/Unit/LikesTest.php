<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_like_a_post()
    {
        // given we have a post
        $post = factory('App\Post')->create();

        // and a logged user
        $user = factory('App\User')->create();
        $this->actingAs($user);

        // when the user like a post
        $post->like();

        // then we should see evidence in the database, and the post should be liked
        $this->assertDatabaseHas('likes',[
           'user_id' => $user->id,
           'likeable_id' => $post->id,
           'likeable_type' => get_class($post),
        ]);

        $this->assertTrue($post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        $post = factory('App\Post')->create();
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $post->like();
        $post->unlike();

        $this->assertDatabaseMissing('likes',[
           'user_id' => $user->id,
           'likeable_id' => $post->id,
           'likeable_type' => get_class($post),
        ]);

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_a_posts_like_status()
    {
        $post = factory('App\Post')->create();

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $post->toggle();
        $this->assertTrue($post->isLiked());

        $post->toggle();
        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {
        $post = factory('App\Post')->create();

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $post->toggle();
        $this->assertEquals(1,$post->likesCount);
    }
}

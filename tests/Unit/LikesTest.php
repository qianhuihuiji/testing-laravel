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
           'likeable_tyle' => get_class($post),
        ]);
    }
}

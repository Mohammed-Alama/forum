<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    function an_unauthenticated_users_may_not_add_replies()
    {
//        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\Thread');

        $reply = create('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());

    }

    /**
     * @test
     */
    function a_authenticated_user_may_participate_in_forum_threads()
    {

        $this->be($user = create('App\User'));

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}

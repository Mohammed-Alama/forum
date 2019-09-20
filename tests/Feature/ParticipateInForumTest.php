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
        $thread = create('App\Thread'); 

        $reply = create('App\Reply');

        $this->withExceptionHandling()
                ->post($thread->path().'/replies',$reply->toArray())
                ->assertRedirect('/login');

    }

    /**
     * @test
     * 1) Tests\Feature\ParticipateInForumTest::a_authenticated_user_may_participate_in_forum_threads
     * Failed asserting that '<!doctype html>\n
     * if we change Route::post to Route::get
     * test will fail and page is loaded
     * if we change Route::get to Route::post
     * test will success and page fail
     */
    function a_authenticated_user_may_participate_in_forum_threads()
    {

//        $this->be($user = create('App\User'));
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /**
     * @test
     * fails
     * Session is missing expected key [errors].
     * Failed asserting that false is true.
     */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply',['body'=>null]);

        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');
    }
}

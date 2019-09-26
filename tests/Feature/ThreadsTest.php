<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;
    public function setUp() :void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();

    }
    /** @test*/
    function a_user_can_view_all_thread()
    {

        $this->get('/threads')

        ->assertSee($this->thread->title);

    }
    /** @test */
    function a_user_can_read_a_single_thread(){

        $this->get($this->thread->path())

        ->assertSee($this->thread->title);
    }
    /** @test */
    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory('App\Reply')
                ->create(['thread_id'=>$this->thread->id]);

        $this   ->get($this->thread->path())
                ->assertSee($reply->body);
    }

    /**
     * @test
     */
    function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread',['channel_id'=>$channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /**
     * @test
     */
    function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User',['name'=>'MohammedAlama']));

        $threadByMohammed = create('App\Thread',['user_id'=>auth()->id()]);

        $threadNotByMohammed = create('App\Thread');

        $this->get('threads?by=MohammedAlama')
            ->assertSee($threadByMohammed->title)
            ->assertDontSee($threadNotByMohammed->title);
    }

    /**
     * @test
     * There was 1 failure:
     */
    function a_user_can_filter_threads_by_popularity()
    {
        $threadWithNoReplies = $this->thread;

        $threadWithTwoReplies = create('App\Thread');

        create('App\Reply',['thread_id'=>$threadWithTwoReplies->id],2);

        $threadWithThreeReplies = create('App\Thread');

        create('App\Reply',['thread_id'=>$threadWithThreeReplies->id],3);

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3,2,0],array_column($response,'replies_count'));
    }
}

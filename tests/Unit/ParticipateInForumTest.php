<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        // Given we have a authenticated user
        $this->be($user=factory('App\User')->create());//已登录用户

//        $user = factory('App\User')->create(); // 未登录用户
        // And an existing thread
        $thread=factory('App\Thread')->create();
        // When the user adds a reply to the thread
        $reply=factory('App\Reply')->make();
        $this->post($thread->path().'/replies/',$reply->toArray());
        // Then their reply should be visible on the page
        $this->get($thread->path())->assertSee($reply->body);
    }

    public function testUnauthenticatedUserMayNoAddReplies()
    {
//        1
        /*$this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();
        $this->post($thread->path().'/replies',$reply->toArray());*/

//        2
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('threads/1/replies',[]);
    }

}

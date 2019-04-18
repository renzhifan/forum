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

//        dd($thread->path() . '/replies');  // 打印出来

        $this->post($thread->path().'/replies/',$reply->toArray());
        // Then their reply should be visible on the page
        $this->get($thread->path())->assertSee($reply->body);
    }

    //未登录用户抛出异常。但是我们真正的测试逻辑应该是：未登录用户试图进行此动作，我们将其重定向至登录页面：
    public function testUnauthenticatedUserMayNoAddReplies()
    {
        $this->withExceptionHandling()
            ->post('threads/some-channel/1/replies',[])
            ->assertRedirect('/login');
    }

}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
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
    //已登录用户能够发布话题
    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        // Given we have a signed in user
        $this->actingAs(factory('App\User')->create());//已登录用户
        // When we hit the endpoint to cteate a new thread
        $thread = factory('App\Thread')->make();
        $this->post('/threads',$thread->toArray());
        // Then,when we visit the thread
        // We should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
    //未登录用户不能添加 thread
    public function testGuestsMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException'); // 在此处抛出异常即代表测试通过
        $thread = factory('App\Thread')->make();
        $this->post('/threads',$thread->toArray());
    }
    //测试未登录用户访问 http://forum.test/threads/create 页面。测试逻辑应为：用户访问页面，如未登录，重定向到 登录页面 。
    public function testGuestsMayNotSeeTheCreateThreadPage()
    {
        $this->withExceptionHandling(); // 此处调用
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

}
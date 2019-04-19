<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Activity;
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
        $this->signIn();  // 已登录用户

        // When we hit the endpoint to cteate a new thread
        $thread = make('App\Thread');
        $response = $this->post('/threads',$thread->toArray());

        // Then,when we visit the thread
        // We should see the new thread
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
    //未登录用户不能添加 thread
    public function testGuestsMayNotCreateThreads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }
    //测试未登录用户访问 http://forum.test/threads/create 页面。测试逻辑应为：用户访问页面，如未登录，重定向到 登录页面 。
    public function testGuestsMayNotSeeTheCreateThreadPage()
    {
        $this->withExceptionHandling(); // 此处调用
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }
    //首先我们来对 $thread 的 title 字段做必填校验：
    public function testAThreadRequiresATitle()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }
    public function testAThreadRequiresABody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }
    public function testAThreadRequiresAValidChannel()
    {
        factory('App\Channel',2)->create(); // 新建两个 Channel，id 分别为 1 跟 2

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])  // channle_id 为 999，是一个不存在的 Channel
        ->assertSessionHasErrors('channel_id');
    }

    /*未登录用户不能进行删除动作；
    已登录用户只能删除自己创建的话题；*/

    public function testGuestsCannotdeleteThreads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $response =  $this->delete($thread->path());

        $response->assertRedirect('/login');
    }
    //测试没有权限的用户删除话题的情形
    public function testUnauthorizedUsersMayNotDeleteThreads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    //删除话题
    public function testAuthorizedUsersCanDeleteThreads()
    {
        $this->signIn();

        $thread = create('App\Thread',['user_id' => auth()->id()]);
        $reply = create('App\Reply',['thread_id' => $thread->id]);

        $response =  $this->json('DELETE',$thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads',['id' => $thread->id]);
        $this->assertDatabaseMissing('replies',['id' => $reply->id]);

        $this->assertEquals(0,Activity::count());
    }
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread',$overrides);

        return $this->post('/threads',$thread->toArray());
    }
    //根据 Channel 筛选 Thread 的功能。
    public function testAUserCanFilterThreadsAccordingToAChannel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread',['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

}

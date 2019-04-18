<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->thread = factory('App\Thread')->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testAUserCanViewAllThreads()
    {
        $this->get('/threads')
            ->
            assertSee($this->thread->title);
    }

    public function testAUserCanReadASingleThread()
    {
        $this->get($this->thread->path())
            ->
            assertSee($this->thread->title);
    }

    public function testAUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        // 如果存在 Thread
        // 并且该 Thread 拥有回复
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
        // 那么当我们看该 Thread 时
        // 我们也要看到回复
        $this->get($this->thread->path())
            ->
            assertSee($reply->body);
    }
}

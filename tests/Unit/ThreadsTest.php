<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
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
    public function testAUserCanViewAllThreads()
    {
        $thread=factory('App\Thread')->create();
        $response = $this->get('/threads');

        $response->assertSee($thread->title);
    }
    public function testAUserCanReadASingleThread()
    {
        $thread=factory('App\Thread')->create();

        $response=$this->get('/threads/'.$thread->id);
        $response->assertSee($thread->title);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
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
    public function testAReplyHasAnOwner()
    {
        $reply = factory('App\Reply')->create();

        $this->assertInstanceOf('App\User',$reply->owner);
    }
}

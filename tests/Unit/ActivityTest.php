<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Activity;
class ActivityTest extends TestCase
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
    public function testItRecordsActivityWhenAThreadIsCreated()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2,Activity::count());
    }
}

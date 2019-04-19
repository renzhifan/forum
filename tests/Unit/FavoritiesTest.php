<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoritiesTest extends TestCase
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
    public function testGuestsCanNotFavoriteAnything()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }
    /** @test */
    public function testAnAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

    $reply = create('App\Reply');

    // If I post a "favorite" endpoint
    $this->post('replies/' . $reply->id . '/favorites');

    // It Should be recorded in the database
    $this->assertCount(1,$reply->favorites);
    }
// 点赞 这个动作，每个用户对同一个回复只能进行一次。所以我们需要增加相关测试：
    public function testAnAuthenticatedUserMayOnlyFavoriteAReplyOnce()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try{
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        }catch (\Exception $e){
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1,$reply->favorites);
    }
}

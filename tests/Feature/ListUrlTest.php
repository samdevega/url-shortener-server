<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ShortUrl;

class ListUrlTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Returns an empty list when there are no records.
     *
     * @return void
     */
    public function test_empty_list()
    {
        $response = $this->get('/urls');

        $response->assertStatus(200);
        $this->assertEquals([], json_decode($response->getContent(), true));
    }

    /**
     * Returns a non empty list of urls.
     *
     * @return void
     */
    public function test_list()
    {
        $token = 'irrelevant';
        $shortUrlModel = new ShortUrl();
        $shortUrlModel->url = $token;
        $shortUrlModel->token = $token;
        $shortUrlModel->save();

        $response = $this->get('/urls');
        $response->assertStatus(200);
        $this->assertEquals([
          'url' => $token,
          'token' => $token
        ], json_decode($response->getContent(), true)[0]);
    }
}

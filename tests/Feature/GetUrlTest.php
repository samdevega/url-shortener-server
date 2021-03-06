<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ShortUrl;

class GetUrlTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Returns not found when URL does not exist.
     *
     * @return void
     */
    public function test_not_found_url()
    {
        $token = 'irrelevant';

        $response = $this->json(
          'GET',
          '/urls/' . $token
        );

        $response->assertStatus(404);
    }

    /**
     * Returns the URL object when exists.
     *
     * @return void
     */
    public function test_found_url()
    {
        $token = 'irrelevant';
        $shortUrlModel = new ShortUrl();
        $shortUrlModel->url = $token;
        $shortUrlModel->token = $token;
        $shortUrlModel->save();

        $response = $this->json(
          'GET',
          '/urls/' . $token
        );

        $response->assertStatus(200);
        $this->assertEquals([
          'url' => $token,
          'token' => $token
        ], json_decode($response->getContent(), true));
    }
}

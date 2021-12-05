<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ShortUrl;

class GetUrlTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tests invalid URL
     *
     * @return void
     */
    public function test_invalid_url()
    {
        $url = 'htp://www.example.com/whatever';

        $response = $this->json(
          'POST',
          '/resolve',
          ['url' => $url]
        );

        $response->assertStatus(400);
    }

    /**
     * Returns not found when URL does not exist.
     *
     * @return void
     */
    public function test_not_found_url()
    {
        $url = 'http://localhost/irrelevant';

        $response = $this->json(
          'POST',
          '/resolve',
          ['url' => $url]
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
        $urlSample = 'http://localhost/irrelevant';
        $shortUrlModel = new ShortUrl();
        $shortUrlModel->long_url = $urlSample;
        $shortUrlModel->short_url = $urlSample;
        $shortUrlModel->save();

        $response = $this->json(
          'POST',
          '/resolve',
          ['url' => $urlSample]
        );

        $response->assertStatus(200);
        $this->assertEquals([
          'long_url' => $urlSample,
          'short_url' => $urlSample
        ], json_decode($response->getContent(), true));
    }
}

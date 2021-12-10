<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\URL;

class NewUrlTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tests invalid URL
     *
     * @return void
     */
    public function test_invalid_url()
    {
        $url = 'htp://www.examplehttp.com/whatever';

        $response = $this->json(
          'POST',
          '/urls',
          ['url' => $url]
        );

        $response->assertStatus(400);
    }

    /**
     * Tests valid URL
     *
     * @return void
     */
    public function test_valid_url()
    {
        $url = 'https://www.example.com/whatever';

        $response = $this->json(
          'POST',
          '/urls',
          ['url' => $url]
        );

        $response->assertStatus(201);
    }

    /**
     * Test response content
     */
    public function test_response_content()
    {
        $url = 'https://www.example.com/whatever';
        $urlPattern = "/^" . preg_quote('http://localhost:8080', '/') . "\/\w+$/i";

        $response = $this->json(
          'POST',
          '/urls',
          ['url' => $url]
        );

        $this->assertEquals($url, $response['long_url']);
        $this->assertEquals(1, preg_match($urlPattern, $response['short_url']));
    }
}

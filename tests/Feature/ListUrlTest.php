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
        $response = $this->get('/history');

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
        $urlSample = 'irrelevant';
        $shortUrlModel = new ShortUrl();
        $shortUrlModel->long_url = $urlSample;
        $shortUrlModel->short_url = $urlSample;
        $shortUrlModel->save();

        $response = $this->get('/history');
        $response->assertStatus(200);
        $this->assertEquals([
          'long_url' => $urlSample,
          'short_url' => $urlSample
        ], json_decode($response->getContent(), true)[0]);
    }
}

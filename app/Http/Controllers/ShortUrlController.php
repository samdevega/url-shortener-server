<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\UseCases\NewUrl;
use App\Http\UseCases\ListUrl;
use App\Http\UseCases\GetUrl;

class ShortUrlController extends Controller
{
    private $newUrl;
    private $listUrl;
    private $getUrl;

    public function __construct() {
        $this->newUrl = new NewUrl();
        $this->listUrl = new ListUrl();
        $this->getUrl = new GetUrl();
    }

    public function create(Request $request)
    {
        $longUrl = $request->url;
        $isValidUrl = $this->validateUrl($longUrl);
        if (!$isValidUrl) {
            return response()->json([
                'message' => $longUrl . ' is not a valid URL'
            ], 400);
        }
        $shortUrl = $this->newUrl->execute($longUrl);
        return response()->json([
            'long_url' => $longUrl,
            'short_url' => $shortUrl
        ], 201);
    }

    public function index()
    {
        $lastUrls = $this->listUrl->execute();
        return response()->json($lastUrls, 200);
    }

    public function show(Request $request)
    {
        $shortUrl = $request->url;
        $isValidUrl = $this->validateUrl($shortUrl);
        if (!$isValidUrl) {
            return response()->json([
                'message' => $shortUrl . ' is not a valid URL'
            ], 400);
        }
        $url = $this->getUrl->execute($shortUrl);
        if (!$url) {
            return response()->json([
                'message' => 'URL not found'
            ], 404);
        }
        return response()->json($url, 200);
    }

    private function validateUrl($url) {
        $urlPattern = "/^ftp|http|https:\/\/[^:]+$/i";
        return preg_match($urlPattern, $url);
    }
}

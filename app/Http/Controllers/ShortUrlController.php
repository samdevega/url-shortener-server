<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\UseCases\NewUrl;
use App\Http\UseCases\ListUrl;

class ShortUrlController extends Controller
{
    private $newUrl;
    private $listUrl;

    public function __construct() {
        $this->newUrl = new NewUrl();
        $this->listUrl = new ListUrl();
    }

    public function create(Request $request)
    {
        $longUrl = $request->url;
        $urlPattern = "/^ftp|http|https:\/\/[^:]+$/i";
        $isInvalidUrl = !preg_match($urlPattern, $longUrl);
        if ($isInvalidUrl) {
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
}

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

    public function store(Request $request)
    {
        $url = $request->url;
        $isValidUrl = $this->validateUrl($url);
        if (!$isValidUrl) {
            return response()->json([
                'message' => $url . ' is not a valid URL'
            ], 400);
        }
        $token = $this->newUrl->execute($url);
        return response()->json([
            'url' => $url,
            'token' => $token
        ], 201);
    }

    public function index()
    {
        $lastUrls = $this->listUrl->execute();
        return response()->json($lastUrls, 200);
    }

    public function show(Request $request)
    {
        $token = $request->route('token');
        $url = $this->getUrl->execute($token);
        if (!$url) {
            return response()->json([
                'message' => 'URL not found'
            ], 404);
        }
        return response()->json($url, 200);
    }

    private function validateUrl($url) {
        $urlPattern = "/^(ftp|http|https):\/\/[^:]+$/i";
        return preg_match($urlPattern, $url);
    }
}

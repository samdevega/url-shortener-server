<?php

namespace App\Http\UseCases;

use App\Models\ShortUrl;

class GetUrl
{
  public function execute($shortUrl)
  {
    return ShortUrl::where('short_url', $shortUrl)
    ->orderBy('created_at', 'desc')
    ->get([
      'long_url',
      'short_url'
    ])
    ->first();
  }
}

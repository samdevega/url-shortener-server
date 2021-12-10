<?php

namespace App\Http\UseCases;

use App\Models\ShortUrl;

class GetUrl
{
  public function execute($token)
  {
    return ShortUrl::where('token', $token)
    ->orderBy('created_at', 'desc')
    ->get([
      'url',
      'token'
    ])
    ->first();
  }
}

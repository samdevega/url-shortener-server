<?php

namespace App\Http\UseCases;

use App\Models\ShortUrl;

class ListUrl
{
  public function execute()
  {
    return ShortUrl::latest()->take(10)->get([
      'url',
      'token'
    ]);
  }
}

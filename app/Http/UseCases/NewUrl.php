<?php

namespace App\Http\UseCases;

use App\Http\Entities\TokenGenerator;
use App\Models\ShortUrl;

class NewUrl
{
  private $tokenGenerator;

  public function __construct() {
      $this->tokenGenerator = new TokenGenerator();
  }

  public function execute($longUrl) {
    $isTaken = false;
    $shortUrl = '';
    do {
      $shortUrl = $this->tokenGenerator->generate();
      $record = ShortUrl::where("short_url", $shortUrl)->first();
      $isTaken = $record !== null;
    } while ($isTaken);
    $shortUrlModel = new ShortUrl();
    $shortUrlModel->long_url = $longUrl;
    $shortUrlModel->short_url = $shortUrl;
    $shortUrlModel->save();
    return $shortUrl;
  }
}

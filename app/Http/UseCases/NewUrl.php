<?php

namespace App\Http\UseCases;

use App\Http\Entities\UrlGenerator;
use App\Models\ShortUrl;

class NewUrl
{
  private $urlGenerator;

  public function __construct() {
      $this->urlGenerator = new UrlGenerator();
  }

  public function execute($longUrl) {
    $isTaken = false;
    $shortUrl = '';
    do {
      $shortUrl = $this->urlGenerator->generate();
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

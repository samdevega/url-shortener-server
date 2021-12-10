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

  public function execute($url) {
    $isTaken = false;
    $token = '';
    do {
      $token = $this->tokenGenerator->generate();
      $record = ShortUrl::where('token', $token)->first();
      $isTaken = $record !== null;
    } while ($isTaken);
    $shortUrlModel = new ShortUrl();
    $shortUrlModel->url = $url;
    $shortUrlModel->token = $token;
    $shortUrlModel->save();
    return $token;
  }
}

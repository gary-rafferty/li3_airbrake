<?php
  require __DIR__ . '/Error.php';

  class Airbrake {

    private $apiKey;

    public function __construct($apiKey) {
      $this->apiKey = $apiKey;
    }

    public function handle($exception,$params) {
      $exception = new Error((object) $exception);
    }
  }
?>

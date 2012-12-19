<?php
  namespace li3_airbrake\models;

  use li3_airbrake\models\Error;
  use li3_airbrake\models\Payload;

  class Airbrake {

    private $apiKey;

    private $name     = 'li3_airbrake - Airbrake plugin for Lithium';
    private $version  = '0.1';
    private $host     = 'http://api.airbrake.io';
    private $resource = '/notifier_api/v2/notices';
    private $repo     = 'https://github.com/gary-rafferty/li3_airbrake';

    public function __construct($apiKey) {
      $this->apiKey = $apiKey;
    }

    public function handle($exception,$params) {
      $exception = new Error((object) $exception);
      $payload = new Payload($exception,$this->config());

      $this->notify($payload);
    }

    private function notify($payload) {

    }

    private function config() {
      return array(
        'name' => $this->name,
        'version' => $this->version,
        'host' => $this->host,
        'resource' => $this->resource,
        'repo' => $this->repo,
        'apiKey' => $this->apiKey
      );
    }
  }
?>

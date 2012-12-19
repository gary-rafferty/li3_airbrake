<?php
  namespace li3_airbrake\models;

  use li3_airbrake\models\Error;
  use li3_airbrake\models\Payload;

  class Airbrake {

    private $apiKey;

    private $name     = 'li3_airbrake - Airbrake plugin for Lithium';
    private $version  = '0.1';
    private $host     = 'api.airbrake.io';
    private $resource = '/notifier_api/v2/notices';
    private $repo     = 'https://github.com/gary-rafferty/li3_airbrake';

    public function __construct($apiKey) {
      $this->apiKey = $apiKey;
    }

    public function handle($exception,$params) {
      $exception = new Error((object) $exception);

      $payload = new Payload($exception,$this->config());

      $xml = $payload->toXML();

      $this->notify($xml);
    }

    private function notify($xml) {
      $fp = fsockopen($this->host,80);
       if(!$fp) {
        return false;
      }

      $http = "POST {$this->resource} HTTP/1.1\r\n";
      $http.= "Host: {$this->host}\r\n";
      $http.= "User-Agent: li3_airbrake\r\n";
      $http.= "Content-Type: application/x-www-form-urlencoded\r\n";
      $http.= "Connection: close\r\n";
      $http.= "Content-Length: ".strlen($xml)."\r\n\r\n";
      $http.= $xml;

      fwrite($fp, $http);
      fclose($fp);

      return true;
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

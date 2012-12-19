<?php

require __DIR__ . '/../models/Airbrake.php';

use lithium\core\Libraries;
use lithium\core\ErrorHandler;

if(!array_key_exists('apikey', Libraries::get('li3_airbrake'))) {
  throw new RuntimeException('You must supply an API key');
}

$apiKey = Libraries::get('li3_airbrake','apikey');

$airbrake = new Airbrake($apiKey);

ErrorHandler::apply(
  'lithium\action\Dispatcher::run', array(), function($exception, $params) use ($airbrake) {
    $airbrake->handle($exception,$params);
  }
);

?>

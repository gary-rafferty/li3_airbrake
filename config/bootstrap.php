<?php

use lithium\core\Libraries;

if(!array_key_exists('apikey', Libraries::get('li3_airbrake'))) {
  throw new RuntimeException('You must supply an API key');
}

$apiKey = Libraries::get('li3_airbrake','apikey');

?>

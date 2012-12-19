# li3_airbrake

## Lithium plugin that reports errors and exceptions to Airbrake

### Installation

Add the project as a git submodule in your li3 app/libraries directory

```bash

git submodule add git://github.com/gary-rafferty/li3_airbrake.git libraries/li3_airbrake

```

and then load it by adding the following to you app/config/bootstrap/libraries.php

```php

<?php

  Libraries::add('li3_airbrake', array('apikey' => '[AIRBRAKE-API-KEY]'))

?>

```

### Usage

li3_airbrake should take care of the rest, and report any errors to Airbrake

### Todo

* Filtering of errors
* Blacklisting of variables
* Testing

### Contributing

* Fork it
* Code it
* Pull (request) it

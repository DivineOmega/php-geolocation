<?php

require_once __DIR__.'/../../vendor/autoload.php';

use DivineOmega\Geolocation\Locator;

$locator = new Locator;

$country = $locator->getCountryByIP('93.184.216.34');

var_dump($country->name);

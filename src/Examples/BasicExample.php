<?php

require_once __DIR__.'/../../vendor/autoload.php';

use DivineOmega\Geolocation\Locator;

$locator = new Locator;

$country = $locator->getCountryByIP('81.150.13.20');

var_dump($country->name);

<?php

require_once __DIR__.'/../../vendor/autoload.php';

use DivineOmega\Geolocation\Locator;
use DivineOmega\Geolocation\LocationProviders\FreeGeoIP;

$locator = new Locator;
$locator->setLocationProvider(new FreeGeoIP);

$country = $locator->getCountryByIP('81.150.13.20');

var_dump($country->name);

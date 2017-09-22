<?php

require_once __DIR__.'/../../vendor/autoload.php';

use DivineOmega\Geolocation\Locator;
use DivineOmega\Geolocation\LocationProviders\FreeGeoIP;

$locator = new Locator;
$locator->setLocationProvider(new FreeGeoIP);

$country = $locator->getCountryByIP('93.184.216.34');

var_dump($country->name);

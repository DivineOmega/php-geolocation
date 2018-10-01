<?php

require_once __DIR__.'/../../vendor/autoload.php';

use DivineOmega\Geolocation\Locator;
use DivineOmega\Geolocation\LocationProviders\IpStack;

$locator = new Locator;
$locator->setLocationProvider(new IpStack("my_ip_stack_api_key"));

$country = $locator->getCountryByIP('81.150.13.20');

var_dump($country->name);

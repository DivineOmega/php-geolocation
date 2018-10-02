<?php

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use Exception;

class FreeGeoIP implements LocationProviderInterface
{

    public function __construct()
    {
        throw new Exception('FreeGeoIP has shutdown, please use the IpStack Locationprovider.');
    }

    public function getCountryByIP(string $ip)
    {
        //
    }
}
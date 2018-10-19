<?php

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use Exception;

class FreeGeoIP implements LocationProviderInterface
{

    /**
     * @see IpStack
     * @see http://freegeoip.net/shutdown
     */
    public function __construct()
    {
        throw new Exception('FreeGeoIP has shutdown, please use the IpStack location provider.');
    }

    public function getCountryByIP(string $ip)
    {
        //
    }
}

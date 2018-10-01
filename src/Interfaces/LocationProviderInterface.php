<?php

namespace DivineOmega\Geolocation\Interfaces;

use DivineOmega\Countries\Country;

interface LocationProviderInterface
{
    /**
     * @param string $ip
     * @return Country
     */
    public function getCountryByIP(string $ip);
}
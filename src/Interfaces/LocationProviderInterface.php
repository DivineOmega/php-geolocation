<?php

namespace DivineOmega\Geolocation\Interfaces;

interface LocationProviderInterface
{
    public function getCountryByIP(string $ip);
}
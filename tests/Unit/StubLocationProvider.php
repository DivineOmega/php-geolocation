<?php
declare(strict_types=1);

namespace DivineOmega\Geolocation\Tests;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use DivineOmega\Countries\Countries;
use DivineOmega\Countries\Country;

class StubLocationProvider implements LocationProviderInterface
{
    public function getCountryByIP(string $ip): ?Country
    {
        if ($ip === '127.0.0.1') {
            $countries = new Countries();
            return $countries->getByName('United States');
        }

        return null;
    }
}

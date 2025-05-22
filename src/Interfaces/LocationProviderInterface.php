<?php
declare(strict_types=1);

namespace DivineOmega\Geolocation\Interfaces;

use DivineOmega\Countries\Country;

interface LocationProviderInterface
{
    /**
     * @param string $ip
     */
    public function getCountryByIP(string $ip): ?Country;
}

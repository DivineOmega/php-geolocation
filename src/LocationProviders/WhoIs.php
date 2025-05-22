<?php
declare(strict_types=1);

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use DivineOmega\Countries\Countries;
use DivineOmega\Countries\Country;
use Exception;

class WhoIs implements LocationProviderInterface
{
    public function getCountryByIP(string $ip): ?Country
    {
        $this->sanityCheck();

        $countryCode = null;
        $lines = [];

        exec('whois '. escapeshellarg($ip), $lines);

        foreach($lines as $line) {

            if (stripos($line, 'country:')!==false) {
                $countryCode = trim(str_ireplace('country:', '', $line));
                break;
            }

        }

        if (!$countryCode) {
            return null;
        }

        $countries = new Countries;

        return $countries->getByIsoCode($countryCode);
    }

    public function sanityCheck(): void
    {
        if (!`which whois`) {
            throw new Exception('The `whois` command is required for this location provider, but it does not seem to be installed.');
        }
    }
}

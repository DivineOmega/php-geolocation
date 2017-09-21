<?php

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use RapidWeb\Countries\Countries;

class WhoIs implements LocationProviderInterface
{
    public function getCountryByIP(string $ip)
    {
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
}
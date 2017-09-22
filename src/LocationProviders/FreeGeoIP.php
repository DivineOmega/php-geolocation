<?php

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use RapidWeb\Countries\Countries;

class FreeGeoIP implements LocationProviderInterface
{
    public function getCountryByIP(string $ip)
    {
        $countryCode = null;
        
        $response = file_get_contents('https://freegeoip.net/json/'.urlencode($ip));

        if (!$response) {
            return null;
        }

        $jsonObj = json_decode($response);

        if (!$jsonObj || !isset($jsonObj->country_code) || !$jsonObj->country_code) {
            return null;
        }

        $countries = new Countries;

        return $countries->getByIsoCode($jsonObj->country_code);
    }
}
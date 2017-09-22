<?php

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use RapidWeb\Countries\Countries;
use GuzzleHttp\Client;

class FreeGeoIP implements LocationProviderInterface
{
    private $client;

    public function __construct($jsonBaseUri = 'https://freegeoip.net/json/')
    {
        $this->client = new Client(['base_uri' => $jsonBaseUri]);
    }

    public function getCountryByIP(string $ip)
    {
        $response = (string) $this->client->get(urlencode($ip))->getBody();
        
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
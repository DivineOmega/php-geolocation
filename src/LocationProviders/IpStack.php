<?php

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use DivineOmega\Countries\Countries;
use GuzzleHttp\Client;

class IpStack implements LocationProviderInterface
{
    private $client;
    private $api_key;

    public function __construct($api_key, $jsonBaseUri = 'http://api.ipstack.com/')
    {
        $this->api_key = $api_key;
        $this->client = new Client(['base_uri' => $jsonBaseUri]);
    }

    public function getCountryByIP(string $ip)
    {
        $arguments = '?access_key=' . $this->api_key . '&output=json';

        $response = (string) $this->client->get(urlencode($ip) . $arguments)->getBody();

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
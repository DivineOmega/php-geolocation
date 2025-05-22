<?php
declare(strict_types=1);

namespace DivineOmega\Geolocation\LocationProviders;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use DivineOmega\Countries\Countries;
use DivineOmega\Countries\Country;
use GuzzleHttp\Client;

class IpStack implements LocationProviderInterface
{
    private Client $client;
    private string $api_key;

    public function __construct(string $api_key, string $jsonBaseUri = 'http://api.ipstack.com/')
    {
        $this->api_key = $api_key;
        $this->client = new Client(['base_uri' => $jsonBaseUri]);
    }

    public function getCountryByIP(string $ip): ?Country
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

<?php

namespace DivineOmega\Geolocation\Tests;

use DivineOmega\Geolocation\Locator;
use DivineOmega\Countries\Country;
use PHPUnit\Framework\TestCase;

class LocatorTest extends TestCase
{
    public function testGetCountryByIpOnUnknownIpAddress()
    {
        $country = (new Locator)->getCountryByIP('93.184.216.34');

        $this->assertNull($country);
    }

    public function testGetCountryByIpOnKnownIpAddress()
    {
        $country = (new Locator)->getCountryByIP('127.0.0.1');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertSame('United States', $country->name);
    }

    public function testGetCountryByIpOnInvalidIpAddress()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The IP address is invalid.');

        (new Locator)->getCountryByIP('127.0.0');
    }
}

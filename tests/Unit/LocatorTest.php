<?php
declare(strict_types=1);

namespace DivineOmega\Geolocation\Tests;

use DivineOmega\Geolocation\Locator;
use DivineOmega\Countries\Country;
use DivineOmega\Geolocation\Tests\StubLocationProvider;
use PHPUnit\Framework\TestCase;

class LocatorTest extends TestCase
{
    public function testGetCountryByIpOnUnknownIpAddress()
    {
        $locator = new Locator();
        $locator->setLocationProvider(new StubLocationProvider());
        $country = $locator->getCountryByIP('93.184.216.34');

        $this->assertNull($country);
    }

    public function testGetCountryByIpOnKnownIpAddress()
    {
        $locator = new Locator();
        $locator->setLocationProvider(new StubLocationProvider());
        $country = $locator->getCountryByIP('127.0.0.1');

        $this->assertInstanceOf(Country::class, $country);
        $this->assertSame('United States', $country->name);
    }

    public function testGetCountryByIpOnInvalidIpAddress()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The IP address is invalid.');

        $locator = new Locator();
        $locator->setLocationProvider(new StubLocationProvider());
        $locator->getCountryByIP('127.0.0');
    }
}

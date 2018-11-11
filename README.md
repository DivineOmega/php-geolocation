# PHP Geolocation

[![Build Status](https://travis-ci.com/DivineOmega/php-geolocation.svg?branch=master)](https://travis-ci.com/DivineOmega/php-geolocation)

This package provides a PHP library that determines the country of an IP address.

## Installation

You can easily install PHP Geolocation with composer.

```
composer require divineomega/php-geolocation
```

## Usage

The most simple usage of PHP Geolocation is to create a new Locator object and call its `getCountryByIP` method.

```php
// Get country of the current request's IP address
$country = (new Locator)->getCountryByIP($_SERVER['REMOTE_ADDR']);

// Get country of a specific IP address
$country = (new Locator)->getCountryByIP('93.184.216.34');

// Returns a Country object
/*
object(DivineOmega\Countries\Country)#4693 (16) {
  ["name"]=>
  string(13) "United States"
  ["officialName"]=>
  string(24) "United States of America"
  // etc...
}
*/
```

### Caching

You can configure PHP Geolocation to use any PSR-6 compliant caching library. This is easily done using the `setCache` method.

The following example configures a file cache (provided by the `cache/filesystem-adapter` package).

```php
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Cache\Adapter\Filesystem\FilesystemCachePool;

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem = new Filesystem($filesystemAdapter);
$cachePool = new FilesystemCachePool($filesystem);

$locator = new Locator;
$locator->setCache($cachePool);

$country = $locator->getCountryByIP('93.184.216.34');
```

### Alternative location providers

By default, PHP Geolocation will try to use the operating system's native `whois` command to determine the IP address. If you wish you
can use an alternative location provider. This can be done using the `setLocationProvider` method, as follows.

```php
$locator = new Locator;
$locator->setLocationProvider(new IpStack('my_ip_stack_api_key');

$country = $locator->getCountryByIP('93.184.216.34');
```

_To get a free api key sign up at [Ip Stack's website](https://ipstack.com)._

If you wish to develop your own location provider, simply create a new class that implements the `LocationProviderInterface` provided in
this package. See the existing `WhoIs` and `FreeGeoIP` location provider classes if you need help creating your own location provider.


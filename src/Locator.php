<?php

namespace DivineOmega\Geolocation;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use DivineOmega\Geolocation\LocationProviders\WhoIs;
use Psr\Cache\CacheItemPoolInterface;

class Locator
{
    private $locationProvider;
    private $cachePool;

    public function __construct()
    {
        $this->setLocationProvider(new WhoIs);
    }

    public function setLocationProvider(LocationProviderInterface $locationProvider)
    {
        $this->locationProvider = $locationProvider;
    }

    public function setCache(CacheItemPoolInterface $cachePool, $cacheExpiresAfter = 60*60*24*365) {
        $this->cachePool = $cachePool;
        $this->cacheExpiresAfter = $cacheExpiresAfter;
    }

    public function getCountryByIP(string $ip)
    {
        if (!$this->cachePool) {
            return $this->locationProvider->getCountryByIP($ip);
        }

        $cacheItem = $this->cachePool->getItem(sha1('ip_'.$ip));
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $country = $this->locationProvider->getCountryByIP($ip);

        $cacheItem->set($country);
        $cacheItem->expiresAfter($this->cacheExpiresAfter);
        $this->cachePool->save($cacheItem);

        return $country;
    }
}
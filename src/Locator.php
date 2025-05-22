<?php
declare(strict_types=1);

namespace DivineOmega\Geolocation;

use DivineOmega\Geolocation\Interfaces\LocationProviderInterface;
use DivineOmega\Geolocation\LocationProviders\WhoIs;
use DivineOmega\Countries\Country;
use Psr\Cache\CacheItemPoolInterface;

class Locator
{
    private LocationProviderInterface $locationProvider;
    private ?CacheItemPoolInterface $cachePool = null;
    private int $cacheExpiresAfter;

    public function __construct()
    {
        $this->setLocationProvider(new WhoIs());
    }

    public function setLocationProvider(LocationProviderInterface $locationProvider): void
    {
        $this->locationProvider = $locationProvider;
    }

    public function setCache(CacheItemPoolInterface $cachePool, int $cacheExpiresAfter = 60 * 60 * 24 * 365): void
    {
        $this->cachePool = $cachePool;
        $this->cacheExpiresAfter = $cacheExpiresAfter;
    }

    public function getCountryByIP(string $ip): ?Country
    {
        if (!$this->isValidIp($ip)) {
            throw new \InvalidArgumentException('The IP address is invalid.');
        }

        if (!$this->cachePool) {
            return $this->locationProvider->getCountryByIP($ip);
        }

        $cacheItem = $this->cachePool->getItem(sha1(__METHOD__.$ip));
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $country = $this->locationProvider->getCountryByIP($ip);

        $cacheItem->set($country);
        $cacheItem->expiresAfter($this->cacheExpiresAfter);
        $this->cachePool->save($cacheItem);

        return $country;
    }

    private function isValidIp(string $ip): bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            return false;
        }

        return true;
    }
}

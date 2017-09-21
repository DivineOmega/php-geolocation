<?php

require_once __DIR__.'/../../vendor/autoload.php';

use DivineOmega\Geolocation\Locator;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Cache\Adapter\Filesystem\FilesystemCachePool;

if (!class_exists('Cache\Adapter\Filesystem\FilesystemCachePool')) {
    die('This example requires the `FilesystemCachePool` class. Install it with `composer require cache/filesystem-adapter`.'.PHP_EOL);
}

$filesystemAdapter = new Local(__DIR__.'/');
$filesystem = new Filesystem($filesystemAdapter);
$cachePool = new FilesystemCachePool($filesystem);

$locator = new Locator;
$locator->setCache($cachePool);

$country = $locator->getCountryByIP('93.184.216.34');

var_dump($country->name);

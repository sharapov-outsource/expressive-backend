<?php

declare(strict_types=1);

/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 *     Date: 2019-04-10
 *     Time: 22:58
 */

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

// To enable or disable caching, set the `ConfigAggregator::ENABLE_CACHE` boolean in
// `config/autoload/local.php`.
$cacheConfig = [
    'config_cache_path' => 'etc/data/cache/config-cache.php',
];

$aggregator = new ConfigAggregator([
    Laminas\Paginator\ConfigProvider::class,
    Laminas\Hydrator\ConfigProvider::class,
    Mezzio\ProblemDetails\ConfigProvider::class,
    Mezzio\Hal\ConfigProvider::class,
    //\Mezzio\HttpHandlerRunner\ConfigProvider::class,
    Mezzio\Router\FastRouteRouter\ConfigProvider::class,
    // Include cache configuration
    new ArrayProvider($cacheConfig),
    Mezzio\Helper\ConfigProvider::class,
    Mezzio\ConfigProvider::class,
    Mezzio\Router\ConfigProvider::class,
    // Default App module config
    App\ConfigProvider::class,
    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    new PhpFileProvider(
        realpath(__DIR__)
        . '/autoload/{{,*.}global,{,*.}local}.php'
    ),
    // Load development config if it exists
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
], $cacheConfig['config_cache_path']);

return $aggregator->getMergedConfig();

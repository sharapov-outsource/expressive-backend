<?php
/**
 * @copyright Sharapov A. <alexander@sharapov.biz>
 * @link      http://www.sharapov.biz/
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License
 * Date: 23.02.2020
 * Time: 23:35
 */

declare(strict_types=1);

namespace ContentManagementTest;

use ContentManagement\ConfigProvider;
use Mezzio\Hal\Metadata\MetadataMap;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    /**
     * @var ConfigProvider
     */
    private $provider;

    protected function setUp(): void
    {
        $this->provider = new ConfigProvider();
    }

    public function testInvocationReturnsArray(): array
    {
        $config = ($this->provider)();
        self::assertIsArray($config);

        return $config;
    }

    /**
     * @depends testInvocationReturnsArray
     */
    public function testReturnedArrayContainsDependencies(array $config): void
    {
        self::assertArrayHasKey('dependencies', $config);
        self::assertArrayHasKey('doctrine', $config);
        self::assertArrayHasKey(MetadataMap::class, $config);
        self::assertArrayHasKey('hydrators', $config);
        self::assertIsArray($config['dependencies']);
        self::assertIsArray($config['doctrine']);
        self::assertIsArray($config[MetadataMap::class]);
        self::assertIsArray($config['hydrators']);
    }
}

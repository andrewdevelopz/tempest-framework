<?php

declare(strict_types=1);

namespace Tempest\Discovery;

use Tempest\Container\Container;
use Tempest\Framework\Application\AppConfig;
use Tempest\Support\Reflection\ClassReflector;

final readonly class DiscoveryDiscovery implements Discovery
{
    public const string CACHE_PATH = __DIR__ . '/../../../.cache/tempest/discovery-discovery.cache.php';

    public function __construct(
        private AppConfig $appConfig,
    ) {
    }

    public function discover(ClassReflector $class): void
    {
        if ($class->getName() === self::class) {
            return;
        }

        if (! $class->implements(Discovery::class)) {
            return;
        }

        $this->appConfig->discoveryClasses[] = $class->getName();
    }

    public function hasCache(): bool
    {
        return file_exists(self::CACHE_PATH);
    }

    public function storeCache(): void
    {
        file_put_contents(self::CACHE_PATH, serialize($this->appConfig->discoveryClasses));
    }

    public function restoreCache(Container $container): void
    {
        $discoveryClasses = unserialize(file_get_contents(self::CACHE_PATH));

        $this->appConfig->discoveryClasses = $discoveryClasses;
    }

    public function destroyCache(): void
    {
        @unlink(self::CACHE_PATH);
    }
}

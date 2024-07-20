<?php

declare(strict_types=1);

namespace Tests\Tempest\Integration;

use Tempest\Application\AppConfig;
use Tempest\Application\Application;
use Tempest\Application\HttpApplication;
use Tempest\Console\ConsoleApplication;
use Tempest\Console\Input\ConsoleArgumentBag;
use Tempest\Console\Output\MemoryOutputBuffer;
use Tempest\Console\Output\StdoutOutputBuffer;
use Tempest\Console\OutputBuffer;
use Tempest\Discovery\DiscoveryDiscovery;
use Tempest\Discovery\DiscoveryLocation;
use Tempest\Testing\IntegrationTest;

abstract class FrameworkIntegrationTestCase extends IntegrationTest
{
    protected function setUp(): void
    {
        $this->appConfig = new AppConfig(
            root: __DIR__ . '/../../',
            enableExceptionHandling: true,
            discoveryCache: true,
            discoveryLocations: [
                new DiscoveryLocation('Tests\\Tempest\\Fixtures', __DIR__ . '/../Fixtures'),
            ],
        );

        parent::setUp();

        $this->container->singleton(OutputBuffer::class, fn () => new MemoryOutputBuffer());
        $this->container->singleton(StdoutOutputBuffer::class, fn () => new MemoryOutputBuffer());

        $databasePath = __DIR__ . '/../Fixtures/database.sqlite';
        $cleanDatabasePath = __DIR__ . '/../Fixtures/database-clean.sqlite';

        @unlink(DiscoveryDiscovery::CACHE_PATH);
        @unlink($databasePath);
        copy($cleanDatabasePath, $databasePath);
    }

    protected function actAsConsoleApplication(string $command = ''): Application
    {
        $application = new ConsoleApplication(
            container: $this->container,
            argumentBag: new ConsoleArgumentBag(['tempest', ...explode(' ', $command)]),
        );

        $this->container->singleton(Application::class, fn () => $application);

        return $application;
    }

    protected function actAsHttpApplication(): HttpApplication
    {
        $application = new HttpApplication(
            $this->container,
            $this->container->get(AppConfig::class),
        );

        $this->container->singleton(Application::class, fn () => $application);

        return $application;
    }
}

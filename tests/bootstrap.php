<?php

declare(strict_types=1);

require_once  __DIR__ . '/../vendor/autoload.php';

passthru('./tempest discovery:clear');
Tempest\Testing\BypassMock\Bypass::enable();

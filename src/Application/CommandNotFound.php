<?php

namespace Tempest\Application;

use Exception;

final class CommandNotFound extends Exception
{
    public function __construct(string $commandName)
    {
        parent::__construct("Command `{$commandName}` not found");
    }
}
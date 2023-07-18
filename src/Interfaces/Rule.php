<?php

declare(strict_types=1);

namespace Tempest\Interfaces;

interface Rule
{
    public function isValid(mixed $value): bool;

    public function message(): string;
}

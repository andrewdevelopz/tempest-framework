<?php

declare(strict_types=1);

namespace Tempest\Console\Highlight\TempestConsoleLanguage\Injections;

use Tempest\Console\Highlight\ConsoleTokenType;
use Tempest\Console\Highlight\IsTagInjection;
use Tempest\Highlight\Injection;

final readonly class CommentInjection implements Injection
{
    use IsTagInjection;

    public function getTag(): string
    {
        return 'comment';
    }

    public function getTokenType(): ConsoleTokenType
    {
        return ConsoleTokenType::COMMENT;
    }
}

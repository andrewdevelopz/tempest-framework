<?php

declare(strict_types=1);

namespace Tests\Tempest\Unit\Console\Terminal;

use Tempest\Console\Console;
use Tempest\Console\Key;
use Tests\Tempest\Unit\Console\ConsoleIntegrationTestCase;

/**
 * @internal
 * @small
 */
class TerminalTest extends ConsoleIntegrationTestCase
{
    public function test_terminal_rendering(): void
    {
        $this->markTestSkipped('Currently broken because of Fiber refactor');
        //
        //        $this->console
        //            ->useInteractiveTerminal()
        //            ->call(function (Console $console) {
        //                $console->writeln(
        //                    json_encode(
        //                        $console->ask('question', ['a', 'b', 'c'], multiple: true),
        //                    ),
        //                );
        //            })
        //            ->assertContains(
        //                <<<TXT
        //> [ ] a
        //  [ ] b
        //  [ ] c
        //TXT,
        //            )
        //            ->assertContains('Press space to select, enter to confirm, ctrl+c to cancel')
        //            ->input(Key::DOWN)
        //            ->input(Key::SPACE)
        //            ->input(Key::DOWN)
        //            ->input(Key::SPACE)
        //            ->assertContains(
        //                <<<TXT
        //  [ ] a
        //  [x] b
        //> [x] c
        //TXT,
        //            )
        //            ->submit()
        //            ->assertContains('["b","c"]');
    }
}

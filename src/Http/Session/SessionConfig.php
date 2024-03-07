<?php

declare(strict_types=1);

namespace Tempest\Http\Session;

use Tempest\Http\Session\Managers\FileSessionManager;
use Tempest\Http\Session\Resolvers\CookieSessionIdResolver;

final readonly class SessionConfig
{
    public function __construct(
        public string $path = __DIR__ . '/sessions',

        /**
         * @template SessionManager of \Tempest\Http\Session\SessionManager
         * @var class-string<SessionManager>
         */
        public string $managerClass = FileSessionManager::class,

        /**
         * @template SessionIdResolver of \Tempest\Http\Session\SessionIdResolver
         * @var class-string<SessionIdResolver>
         */
        public string $idResolverClass = CookieSessionIdResolver::class,
    ) {
    }
}

<?php

declare(strict_types=1);

namespace Tests\Tempest\Integration\Route;

use Tempest\Database\Migrations\CreateMigrationsTable;
use Tempest\Http\GenericRouter;
use Tempest\Http\Responses\Ok;
use Tempest\Http\Router;
use Tempest\Http\Status;
use Tests\Tempest\Fixtures\Controllers\TestController;
use Tests\Tempest\Fixtures\Controllers\TestGlobalMiddleware;
use Tests\Tempest\Fixtures\Migrations\CreateAuthorTable;
use Tests\Tempest\Fixtures\Migrations\CreateBookTable;
use Tests\Tempest\Fixtures\Modules\Books\Models\Author;
use Tests\Tempest\Fixtures\Modules\Books\Models\Book;
use Tests\Tempest\Integration\FrameworkIntegrationTestCase;

/**
 * @internal
 * @small
 */
class RouterTest extends FrameworkIntegrationTestCase
{
    public function test_dispatch()
    {
        $router = $this->container->get(GenericRouter::class);

        $response = $router->dispatch($this->http->makePsrRequest('/test'));

        $this->assertEquals(Status::OK, $response->getStatus());
        $this->assertEquals('test', $response->getBody());
    }

    public function test_dispatch_with_parameter()
    {
        $router = $this->container->get(GenericRouter::class);

        $response = $router->dispatch($this->http->makePsrRequest('/test/1/a'));

        $this->assertEquals(Status::OK, $response->getStatus());
        $this->assertEquals('1a', $response->getBody());
    }

    public function test_generate_uri()
    {
        $router = $this->container->get(GenericRouter::class);

        $this->assertEquals('/test/1/a', $router->toUri([TestController::class, 'withParams'], id: 1, name: 'a'));
        $this->assertEquals('/test', $router->toUri(TestController::class));
    }

    public function test_with_view()
    {
        $router = $this->container->get(GenericRouter::class);

        $response = $router->dispatch($this->http->makePsrRequest('/view'));

        $this->assertInstanceOf(Ok::class, $response);
    }

    public function test_route_binding()
    {
        $this->migrate(
            CreateMigrationsTable::class,
            CreateBookTable::class,
            CreateAuthorTable::class,
        );

        Book::create(
            title: 'Test',
            author: new Author(name: 'Brent'),
        );

        $router = $this->container->get(Router::class);

        $response = $router->dispatch($this->http->makePsrRequest('/books/1'));

        $this->assertSame(Status::OK, $response->getStatus());
        $this->assertSame('Test', $response->getBody());
    }

    public function test_middleware()
    {
        $router = $this->container->get(GenericRouter::class);

        $router->addMiddleware(TestGlobalMiddleware::class);

        $response = $router->dispatch($this->http->makePsrRequest('/with-middleware'));

        $this->assertEquals(['from-dependency'], $response->getHeader('middleware')->values);
        $this->assertEquals(['yes'], $response->getHeader('global-middleware')->values);
    }
}

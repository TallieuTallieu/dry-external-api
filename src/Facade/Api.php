<?php

namespace Tnt\ExternalApi\Facade;

use Oak\Facade;
use Tnt\ExternalApi\Router\Router;

/**
 * @method static void get(string $version, string $pattern, string $controller, string $method)
 * @method static void post(string $version, string $pattern, string $controller, string $method)
 * @method static void put(string $version, string $pattern, string $controller, string $method)
 * @method static void patch(string $version, string $pattern, string $controller, string $method)
 * @method static void delete(string $version, string $pattern, string $controller, string $method)
 *
 * @extends Facade<Router>
 */
class Api extends Facade
{
	protected static function getContract(): string
	{
		return Router::class;
	}
}
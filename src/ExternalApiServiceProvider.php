<?php

namespace Tnt\ExternalApi;

use dry\route\Router;
use Oak\Contracts\Container\ContainerInterface;
use Oak\ServiceProvider;
use Tnt\ExternalApi\Router\Router as ApiRouter;

class ExternalApiServiceProvider extends ServiceProvider
{
	public function boot(ContainerInterface $app)
	{
		Router::register([
			'api/v(?<version>\d+)/(?<path>.+)' => '\\Tnt\\ExternalApi\\Facade\\Api::route',
		]);
	}

	public function register(ContainerInterface $app)
	{
		$app->instance(ContainerInterface::class, $app);
		$app->singleton(ApiRouter::class, ApiRouter::class);
	}
}
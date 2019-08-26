<?php

namespace Tnt\ExternalApi\Facade;

use Oak\Facade;
use Tnt\ExternalApi\Router\Router;

class Api extends Facade
{
	protected static function getContract(): string
	{
		return Router::class;
	}
}
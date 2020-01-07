# dry-external-api
### An external API for your DRY applications

#### Installation

```ssh
composer require dietervyncke/dry-external-api
```

#### Example usage

##### Route definition

```php
<?php

use Tnt\ExternalApi\Facade\Api;

/**
 * Get request
 * string $version, string $pattern, $controller, $method
*/
Api::get('1', 'users/(?<id>\d+)', Acme\Controller\UserController::class, 'get');

/**
 * Post request
 * string $version, string $pattern, $controller, $method
*/
Api::post('1', 'users', UserController::class, 'create');

/**
 * Patch request
 * string $version, string $pattern, $controller, $method
 */
Api::patch('1', 'users/(?<id>\d+)', UserController::class, 'update');

/**
 * Put request
 * string $version, string $pattern, $controller, $method
 */
Api::put('1', 'users/(?<id>\d+)', UserController::class, 'update');

/**
 * Delete request
 * string $version, string $pattern, $controller, $method
 */
Api::delete('1', 'users/(?<id>\d+)', UserController::class, 'delete');
```

##### Controller
```php
<?php

namespace Acme\Controller;

use model\User;
use dry\db\FetchException;
use dry\db\DuplicateEntryException;
use Tnt\ExternalApi\Exception\ApiException;
use Tnt\ExternalApi\Http\Request;

class UserController
{
	public static function get(Request $request)
	{
		try {
			$user = User::load($request->parameters->integer('id'));
		} catch (FetchException $e) {
			throw new ApiException('user_not_found');
		}
		
		return [
			'email' => $user->email,
			'firstName' => $user->first_name,
			'lastName' => $user->last_name,
		];
	}
	
	public function create(Request $request)
	{
		$request->validate([
			'email',
			'password',
		]);
	
		try {
			User::load_by( 'email', $request->data->string( 'email' ) );
		} catch (DuplicateEntryException $e) {
	    		throw new ApiException('duplicate_user');
		} catch(FetchException $e) {}
		
		$user = new User();
		$user->email = $request->data->string( 'email' );
		$user->password = $request->data->string( 'password' );
		$user->save();
	}
}
```

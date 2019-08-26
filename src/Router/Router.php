<?php

namespace Tnt\ExternalApi\Router;

use dry\internals\http\RequestDataWrapper;
use Tnt\ExternalApi\Exception\ApiException;
use Tnt\ExternalApi\Http\Request;

class Router
{
	/**
	 * @var array $get
	 */
	private $get = [];

	/**
	 * @var array $post
	 */
	private $post = [];

	/**
	 * @var array $put
	 */
	private $put = [];

	/**
	 * @var array $patch
	 */
	private $patch = [];

	/**
	 * @var array $delete
	 */
	private $delete = [];

	/**
	 * @param string $version
	 * @param string $pattern
	 * @param $controller
	 */
	public function get(string $version, string $pattern, $controller)
	{
		$this->get['v'.$version.'/'.$pattern] = $controller;
	}

	/**
	 * @param string $version
	 * @param string $pattern
	 * @param $controller
	 */
	public function post(string $version, string $pattern, $controller)
	{
		$this->post['v'.$version.'/'.$pattern] = $controller;
	}

	/**
	 * @param string $version
	 * @param string $pattern
	 * @param $controller
	 */
	public function put(string $version, string $pattern, $controller)
	{
		$this->put['v'.$version.'/'.$pattern] = $controller;
	}

	/**
	 * @param string $version
	 * @param string $pattern
	 * @param $controller
	 */
	public function patch(string $version, string $pattern, $controller)
	{
		$this->patch['v'.$version.'/'.$pattern] = $controller;
	}

	/**
	 * @param string $version
	 * @param string $pattern
	 * @param $controller
	 */
	public function delete(string $version, string $pattern, $controller)
	{
		$this->delete['v'.$version.'/'.$pattern] = $controller;
	}

	/**
	 * @param \dry\http\Request $request
	 */
	public function route(\dry\http\Request $request)
	{
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE');
		header('Access-Control-Max-Age: 600');
		header('Access-Control-Allow-Headers: authorization');

		$request = new Request($request);

		$map = [
			'GET' => $this->get,
			'POST' => $this->post,
			'PUT' => $this->put,
			'PATCH' => $this->patch,
			'DELETE' => $this->delete,
		];

		$routes = [];

		if (isset($map[$request->getMethod()])) {
			$routes = $map[$request->getMethod()];
		}

		$return = null;

		foreach ($routes as $pattern => $controller) {

			if (preg_match('#^('.$pattern.')$#', $request->getPath(), $m)) {
				$request->parameters = new RequestDataWrapper($m);

				try
				{
					$return = [
						'success' => true,
						'result' => call_user_func($controller, $request),
					];
				}
				catch (ApiException $e)
				{
					$return = [
						'success' => false,
						'error_code' => $e->getCode(),
						'data' => $e->data,
					];
				}
			}
		}

		if ($return === null) {
			$return = [
				'success' => false,
				'error_code' => 'invalid_action',
			];
		}

		\dry\http\Response::set_content_type(\dry\http\Response::APPLICATION_JSON);
		echo json_encode($return);
	}
}
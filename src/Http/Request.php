<?php

namespace Tnt\ExternalApi\Http;

use dry\internals\http\RequestDataWrapper;
use Tnt\ExternalApi\Exception\ApiException;

class Request
{
	/**
	 * @var string $path
	 */
	private $path;

	/**
	 * @var string $method
	 */
	private $method;

	/**
	 * @var array $headers
	 */
	private $headers = [];

	/**
	 * @var RequestDataWrapper $parameters
	 */
	public $parameters = [];


	/**
	 * @var $data
	 */
	public $data;

	/**
	 * Request constructor.
	 * @param \dry\http\Request $request
	 */
	public function __construct(\dry\http\Request $request)
	{
		$this->path = 'v'.$request->parameters->string('version').'/'.$request->parameters->string('path');
		$this->method = $request->method;

		$map = [
			'GET' => 'get',
			'POST' => 'post',
			'PUT' => 'put',
			'PATCH' => 'put',
			'DELETE' => 'put',
		];

		if (isset($map[$request->method])) {

			$this->data = $request->{$map[$request->method]};

			if (!$this->data instanceof RequestDataWrapper) {
				$rawData = json_decode($request->{$map[$request->method]}, TRUE);
				$this->data = new RequestDataWrapper($rawData);
			}
		}

		$authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? NULL;

		if ($authorizationHeader) {

			if (stripos($authorizationHeader, 'Basic ') === 0) {
				$exploded = explode(':', base64_decode(substr($authorizationHeader, 6)), 2);

				if (count($exploded) === 2) {
					$this->headers['USER'] = $exploded[0];
					$this->headers['PASSWORD'] = $exploded[1];
				}
			}
			elseif (stripos($authorizationHeader, 'Bearer ') === 0) {
				$this->headers['AUTHORIZATION'] = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
			}
		}
	}

	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}

	/**
	 * @return mixed
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function getHeader(string $key)
	{
		if (!isset($this->headers[$key])) {
			return null;
		}

		return $this->headers[$key];
	}

	/**
	 * @param array $requiredParameters
	 * @param array $optionalParameters
	 * @throws ApiException
	 */
	public function validate(array $requiredParameters = [], array $optionalParameters = [])
	{
		foreach ($requiredParameters as $parameterName) {
			if (! $this->data->has($parameterName)) {
				throw new ApiException('missing_required_parameter', $parameterName);
			}
		}
	}
}

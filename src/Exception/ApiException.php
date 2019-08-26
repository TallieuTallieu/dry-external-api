<?php

namespace Tnt\ExternalApi\Exception;

class ApiException extends \Exception
{
	/**
	 * @var string $code
	 */
	public $code;

	/**
	 * @var $data
	 */
	public $data;

	/**
	 * ApiException constructor.
	 * @param string $code
	 * @param $data
	 */
	public function __construct(string $code, $data = NULL)
	{
		$this->code = $code;
		$this->data = $data;
	}
}
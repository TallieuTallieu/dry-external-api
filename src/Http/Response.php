<?php

namespace Tnt\ExternalApi\Http;

class Response
{
    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_INTERNAL_ERROR = 500;

    const CODE_BAD_REQUEST = 'bad_request';
    const CODE_INVALID_DATA = 'invalid_data';
    const CODE_UNAUTHORIZED = 'unauthorized';
    const CODE_FORBIDDEN = 'forbidden';
    const CODE_NOT_FOUND = 'not_found';
    const CODE_INTERNAL_ERROR = 'internal_error';


	/**
	 * @var array $dumped
	 */
	public static $dumped = [];

	/**
	 * @param $value
	 */
	public static function dump($value)
	{
		self::$dumped = json_encode($value);
	}

    /**
    * @var int $status
    */
    public $status;

    /**
    * @var array $data
    */
    public $data;
    
    /**
    * @var string $error_code
    */
    public $error_code;

    public function is_success() {
        return $this->status == self::STATUS_OK || $this->status == self::STATUS_CREATED;
    }

    public function __construct($data = [], $status = self::STATUS_OK, $error_code = null)
    {
        $this->data = $data;
        $this->status = $status;
        $this->error_code = $error_code;
    }

    public static function ok($data = [])
    {
        return new self($data);
    }

    public static function created($data = [])
    {
        return new self($data, self::STATUS_CREATED);
    }

    public static function badRequest($data = [], $error_code = self::CODE_BAD_REQUEST)
    {
        return new self($data, self::STATUS_BAD_REQUEST, $error_code);
    }

    public static function invalidData(ValidationData $data, $error_code = self::CODE_INVALID_DATA)
    {
        return new self($data, self::STATUS_BAD_REQUEST, $error_code);
    }

    public static function unauthorized($data = [], $error_code = self::CODE_UNAUTHORIZED)
    {
        return new self($data, self::STATUS_UNAUTHORIZED, $error_code);
    }

    public static function forbidden($data = [], $error_code = self::CODE_FORBIDDEN)
    {
        return new self($data, self::STATUS_FORBIDDEN, $error_code);
    }

    public static function notFound($data = [], $error_code = self::CODE_NOT_FOUND)
    {
        return new self($data, self::STATUS_NOT_FOUND, $error_code);
    }

    public static function internalError($data = [], $error_code = self::CODE_INTERNAL_ERROR)
    {
        return new self($data, self::STATUS_INTERNAL_ERROR, $error_code);
    }

    public function toArray() {
        return [
            'success' => $this->is_success(),
            'error_code' => $this->error_code,
            'data' => $this->data,
        ];
    }
}

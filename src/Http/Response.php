<?php

namespace Tnt\ExternalApi\Http;

class Response
{
    static const STATUS_OK = 200;
    static const STATUS_CREATED = 201;
    static const STATUS_BAD_REQUEST = 400;
    static const STATUS_UNAUTHORIZED = 401;
    static const STATUS_FORBIDDEN = 403;
    static const STATUS_NOT_FOUND = 404;
    static const STATUS_INTERNAL_ERROR = 500;

    static const CODE_BAD_REQUEST = 'bad_request';
    static const CODE_INVALID_DATA = 'invalid_data';
    static const CODE_UNAUTHORIZED = 'unauthorized';


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

    public function toArray() {
        return [
            'success' => $this->is_success(),
            'error_code' => $this->error_code,
            'data' => $this->data,
        ];
    }
}

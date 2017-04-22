<?php

namespace TiMacDonald\Kumulos;

class Response
{
    /**
     * Response status codes provided by Kumulos API.
     *
     * @var int
     */
    const SUCCESS_RESPONSE_CODE = 1,
          NOT_AUTHORISED_RESPONSE_CODE = 2,
          NO_SUCH_METHOD_RESPONSE_CODE = 4,
          NO_SUCH_FORMAT_RESPONSE_CODE = 8,
          ACCOUNT_SUSPENDED_RESPONSE_CODE = 16,
          INVALID_REQUEST_RESPONSE_CODE = 32,
          ERROR_RESPONSE_CODE = 64,
          NORMALIZED_ERROR_RESPONSE_CODE = 500;

    /**
     * Response status codes messages provided by Kumulos API.
     *
     * @var array
     */
    const RESPONSE_CODES_MESSAGES = [
        1 => 'Success',
        2 => 'Not authorised',
        4 => 'No such method',
        8 => 'No such format',
        16 => 'Account suspended',
        32 => 'Invalid request',
        64 => 'Unknown server error'
    ];

    /**
     * Normalized version of the Kumulos response codes.
     * @link http://bit.ly/2ovBMPg
     *
     * @var array
     */
    const NORMALIZED_RESPONSE_CODES = [
        1 => 200,
        2 => 401,
        4 => 405,
        8 => 406,
        16 => 402,
        32 => 400,
        64 => 500
    ];

    /**
     * Normalized version of the Kumulos response messages.
     *
     * @var array
     */
    const NORMALIZED_RESPONSE_CODES_MESSAGES = [
        200 => 'OK',
        401 => 'Unauthorized',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        402 => 'Payment Required',
        400 => 'Bad Request',
        500 => 'Internal Server Error'
    ];

    /**
     * The decoded response data retrieved from the Kumulos API
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new instance.
     *
     * @param  string  $data
     */
    public function __construct($data)
    {
        $this->data = json_decode($data, true) ?: [];
    }

    /**
     * Indicates a failure response.
     *
     * @return bool
     */
    public function failed()
    {
        return $this->statusCode() != static::SUCCESS_RESPONSE_CODE;
    }

    /**
     * Status code provided by the Kumulos API
     *
     * @return int
     */
    public function statusCode()
    {
        return $this->data('responseCode') ?: static::ERROR_RESPONSE_CODE;
    }

    /**
     * Normalized version of the status code provided by the Kumulos API
     *
     * @return int
     */
    public function normalizedStatusCode()
    {
        if (array_key_exists($this->statusCode(), static::NORMALIZED_RESPONSE_CODES)) {
            return static::NORMALIZED_RESPONSE_CODES[$this->statusCode()];
        }

        return static::NORMALIZED_RESPONSE_CODES[static::ERROR_RESPONSE_CODE];
    }

    /**
     * Status code message provided by the Kumulos API
     *
     * @return string
     */
    public function message()
    {
        if (array_key_exists($this->statusCode(), static::RESPONSE_CODES_MESSAGES)) {
            return static::RESPONSE_CODES_MESSAGES[$this->statusCode()];
        }

        return static::RESPONSE_CODES_MESSAGES[static::ERROR_RESPONSE_CODE];
    }

    /**
     * Normalized version of the message provided by the Kumulos API.
     *
     * @return string
     */
    public function normalizedMessage()
    {
        if (array_key_exists($this->normalizedStatusCode(), static::NORMALIZED_RESPONSE_CODES_MESSAGES)) {
            return static::NORMALIZED_RESPONSE_CODES_MESSAGES[$this->normalizedStatusCode()];
        }

        return static::NORMALIZED_RESPONSE_CODES_MESSAGES[static::NORMALIZED_ERROR_RESPONSE_CODE];
    }

    /**
     * API provided payload.
     *
     * @return array
     */
    public function payload()
    {
        return $this->data('payload') ?: [];
    }

    /**
     * Get response data by key.
     *
     * @return string|null
     */
    protected function data($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
    }
}

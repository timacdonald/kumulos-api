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
          ERROR_RESPONSE_CODE = 64;

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
        $this->data = json_decode($data) ?: [];
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
        return $this->responseCode ?? 0;
    }

    /**
     * Status code message provided by the Kumulos API
     *
     * @return string
     */
    public function message()
    {
        if ($this->responseMessage) {
            return $this->responseMessage;
        }

        if (array_key_exists($this->responseCode, static::RESPONSE_CODES_MESSAGES)) {
            return static::RESPONSE_CODES_MESSAGES[$this->responseCode];
        }

        return static::RESPONSE_CODES_MESSAGES[static::ERROR_RESPONSE_CODE];
    }

    /**
     * API provided payload.
     *
     * @return array
     */
    public function payload()
    {
        return $this->payload;
    }

    /**
     * Delegate undeclared property access.
     *
     * @return mixed|null
     */
    protected function __get($property)
    {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
    }
}

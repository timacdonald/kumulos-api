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
     * Unknown error message.
     *
     * @var string
     */
    const UNKNOWN_ERROR_MESSAGE = 'An unknown error occurred';

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
     * @return int|null
     */
    public function statusCode()
    {
        return $this->data('responseCode');
    }

    /**
     * Status code message provided by the Kumulos API
     *
     * @return string
     */
    public function message()
    {
        return $this->data('responseMessage') ??
               $this->responseCodeMessage() ??
               static::UNKNOWN_ERROR_MESSAGE;
    }

    /**
     * Message for response code.
     *
     * @return string|null
     */
    protected function responseCodeMessage()
    {
        if (array_key_exists($this->data('responseCode'), static::RESPONSE_CODES_MESSAGES)) {
            return static::RESPONSE_CODES_MESSAGES[$this->data('responseCode')];
        }
    }

    /**
     * API provided payload.
     *
     * @return array
     */
    public function payload()
    {
        return $this->data('payload');
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

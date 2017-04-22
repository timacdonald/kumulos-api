<?php

namespace TiMacDonald\Kumulos;

use Exception;

class Api
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var TiMacDonald\Kumulos\Request
     */
    protected $request;

    /**
     * @var TiMacDonald\Kumulos\Response
     */
    protected $response;

    /**
     * Create a new instance.
     *
     * @param  $apiKey  string
     * @param  $secret  string
     */
    public function __construct($apiKey, $secret)
    {
        $this->apiKey = $apiKey;

        $this->secret = $secret;
    }

    /**
     * Delegate undeclared method calls.
     *
     * @param  $method  string
     * @param  $arguments  array
     * @return TiMacDonald\Kumulos\Response
     */
    public function __call($method, $arguments)
    {
        $this->request = new Request($method, $arguments[0], $this->apiKey, $this->secret);

        return $this->response = $this->request->send();
    }

    /**
    * Get request.
    *
     * @return TiMacDonald\Kumulos\Request|null
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Ger response.
     *
     * @return TiMacDonald\Kumulos\Response|null
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Indicates a failure response.
     *
     * @return bool
     *
     * @throws Exception
     */
    public function failed()
    {
        if (is_null($this->response)) {
            throw new Exception('You must send the API request before you can determine if it failed');
        }

        return $this->response->failed();
    }
}

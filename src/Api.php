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
    protected $secretKey;

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
     * @return array
     *
     * @throws \Exception
     */
    public function __call($method, $arguments)
    {
        $request = new Request($method, $arguments, $this->apiKey, $this->secret);

        $response = $request->send();

        if ($response->failed()) {
            throw new Exception($response->message(), $response->statusCode());
        }

        return $response->payload();
    }
}

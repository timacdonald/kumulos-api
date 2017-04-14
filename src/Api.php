<?php

namespace TiMacDonald\Kumulos;

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
        $request = new Request($method, $arguments[0], $this->apiKey, $this->secret);

        return $request->send();
    }
}

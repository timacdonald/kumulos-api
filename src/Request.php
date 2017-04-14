<?php

namespace TiMacDonald\Kumulos;

class Request
{
    /**
     * @var string
     */
    const BASE_URL = 'https://api.kumulos.com';

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * Create a new instance.
     *
     * @param  $action  string
     * @param  $parameters  array
     * @param  $apiKey  string
     * @param  $secretKey  string
     */
    public function __construct($action, $parameters, $apiKey, $secretKey)
    {
        $this->url = static::BASE_URL.'/'.$apiKey.'/'.$action.'.json';

        $salt = static::generateSalt();

        $this->parameters = [
            'salt' => $salt,
            'params' => $parameters,
            'hashedKey' => md5($secretKey.$salt)
        ];
    }

    /**
     * Generate a salt.
     *
     * @return int
     */
    protected static function generateSalt()
    {
        return rand(1, 999999);
    }

    /**
     * Perform the actual http request.
     *
     * @return TiMacDonald\Kumulos\Response
     */
    public function send()
    {
        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->parameter));

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

        curl_close($ch);

        return new Response($response);
    }
}

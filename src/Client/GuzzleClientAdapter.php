<?php
namespace Aeq\Hal\Client;

use GuzzleHttp\Client;

class GuzzleClientAdapter implements ClientAdapterInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    public function request($method, $uri = null, array $options = [])
    {
        return $this->guzzleClient->request($method, $uri, $options);
    }
}

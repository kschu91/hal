<?php
namespace Aeq\Hal\Client;

use GuzzleHttp\ClientInterface;

class GuzzleClientAdapter implements ClientAdapterInterface
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

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

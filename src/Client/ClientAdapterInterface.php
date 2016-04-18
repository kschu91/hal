<?php
namespace Aeq\Hal\Client;

use Psr\Http\Message\ResponseInterface;

interface ClientAdapterInterface
{
    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function request($method, $uri = null, array $options = []);
}

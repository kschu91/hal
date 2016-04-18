<?php
namespace Aeq\Hal\Client;

use GuzzleHttp\Psr7\Response;

class UnitTestClientAdapter implements ClientAdapterInterface
{
    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return Response
     */
    public function request($method, $uri = null, array $options = [])
    {
        $fixture = __DIR__ . '/../fixture/' . $uri . '.json';
        if (!file_exists($fixture)) {
            return new Response(404);
        }
        $json = file_get_contents(__DIR__ . '/../fixture/' . $uri . '.json');
        return new Response(200, [], $json);
    }
}

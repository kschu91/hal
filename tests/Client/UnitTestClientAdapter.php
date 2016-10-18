<?php
namespace Aeq\Hal\Client;

use Aeq\Hal\Client\PSR7\Response;
use Aeq\Hal\Client\PSR7\Stream;

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
            $response = new Response();
            $response->withStatus(404);
            return $response;
        }
        $json = file_get_contents(__DIR__ . '/../fixture/' . $uri . '.json');
        $response = new Response();
        $response->withStatus(200);
        $response->withBody(new Stream($json));
        return $response;
    }
}

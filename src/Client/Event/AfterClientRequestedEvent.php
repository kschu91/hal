<?php
namespace Aeq\Hal\Client\Event;

use Aeq\Hal\Event\EventInterface;
use Psr\Http\Message\ResponseInterface;

class AfterClientRequestedEvent implements EventInterface
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
}

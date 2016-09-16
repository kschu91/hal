<?php
namespace Aeq\Hal\Client;

use Aeq\Hal\Client\Event\AfterClientRequestedEvent;
use Aeq\Hal\Event\EventingAware;
use Aeq\Hal\Exception\InvalidResponseException;
use Psr\Http\Message\ResponseInterface;

trait ClientAdapterAware
{
    use EventingAware;

    /**
     * @var ClientAdapterInterface
     */
    private $clientAdapter;

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws InvalidResponseException
     */
    public function request($method, $uri = null, array $options = [])
    {
        if ($this->clientAdapter instanceof ClientAdapterInterface) {
            $response = $this->clientAdapter->request($method, $uri, $options);

            if ($response->getStatusCode() >= 400) {
                throw new InvalidResponseException(
                    sprintf('Status code "%s" for "%s"', $response->getStatusCode(), $uri),
                    1474016330
                );
            }

            $this->triggerEvent(new AfterClientRequestedEvent($response));

            return $response;
        }
        throw new \LogicException(sprintf('no client adapter set for "%s"', __CLASS__), 1460021696);
    }

    /**
     * @param ClientAdapterInterface $clientAdapter
     */
    public function setClientAdapter($clientAdapter)
    {
        $this->clientAdapter = $clientAdapter;
    }
}

<?php
namespace Aeq\Hal\Client;

use Psr\Http\Message\ResponseInterface;

trait ClientAdapterAware
{
    /**
     * @var ClientAdapterInterface
     */
    private $clientAdapter;

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function request($method, $uri = null, array $options = [])
    {
        if ($this->clientAdapter instanceof ClientAdapterInterface) {
            return $this->clientAdapter->request($method, $uri, $options);
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

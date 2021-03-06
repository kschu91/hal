<?php
namespace Aeq\Hal;

use Aeq\Hal\Client\ClientAdapterAware;
use Aeq\Hal\Explorer\Resource as HalResource;
use Aeq\Hal\Explorer\ResourceCollection;
use Aeq\Hal\Explorer\ResourceFactory;
use Aeq\Hal\Serializer\SerializeAware;
use Psr\Http\Message\ResponseInterface;

class Explorer
{
    use SerializeAware;
    use ClientAdapterAware;

    /**
     * @param ResponseInterface $response
     * @return HalResource|ResourceCollection
     */
    public function explore(ResponseInterface $response)
    {
        return ResourceFactory::create($this, $this->deserialize($response->getBody()));
    }
}

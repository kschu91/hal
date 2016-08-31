<?php
namespace Aeq\Hal\Explorer\Resource;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource\Resource as HalResource;

class ResourceCollection implements \Iterator, ResourceInterface
{
    /**
     * @var ResourceInterface[]
     */
    private $resources = [];

    /**
     * @var Explorer
     */
    private $explorer;

    /**
     * @param Explorer $explorer
     */
    public function __construct(Explorer $explorer)
    {
        $this->explorer = $explorer;
    }

    /**
     * @param ResourceInterface $resource
     */
    public function addResource(ResourceInterface $resource)
    {
        $this->resources[] = $resource;
    }

    /**
     * @return HalResource
     */
    public function current()
    {
        return current($this->resources);
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->resources);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->resources);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->resources) !== null;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->resources);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];
        foreach ($this->resources as $item) {
            $data[] = $item->getData();
        }
        return $data;
    }
}

<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;

class ResourceCollection implements \Iterator, ResourceableInterface
{
    /**
     * @var array<HalResource>
     */
    private $resources = [];

    /**
     * @var Explorer
     */
    private $explorer;

    /**
     * @param Explorer $explorer
     * @param array<HalResource> $resources
     */
    public function __construct(Explorer $explorer, array $resources)
    {
        $this->explorer = $explorer;
        $this->resources = $resources;
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
            /** @var HalResource $item */
            $data[] = $item->getData();
        }
        return $data;
    }
}

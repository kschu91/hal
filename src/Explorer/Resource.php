<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Exception\NotFoundException;
use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;

class Resource implements ResourceableInterface
{
    /**
     * @var Explorer
     */
    private $explorer;

    /**
     * @var array
     */
    private $properties;

    /**
     * @var array
     */
    private $links;

    /**
     * @var array<ResourceableInterface>
     */
    private $embedded;

    /**
     * @param Explorer $explorer
     * @param array $properties
     * @param array $links
     * @param array $embedded
     */
    public function __construct(Explorer $explorer, array $properties, array $links = [], array $embedded = [])
    {
        $this->explorer = $explorer;
        $this->properties = $properties;
        $this->links = $links;
        $this->embedded = $embedded;
    }

    /**
     * @param string $name
     * @return Link|LinkCollection
     * @throws NotFoundException
     */
    public function getLink($name)
    {
        if (!$this->hasLink($name)) {
            throw new NotFoundException(sprintf('link "%s" not found', $name), 1460663568);
        }
        /** @var AbstractLink $link */
        $link = $this->links[$name];
        $link->setParent($this);
        return $link;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasLink($name)
    {
        return isset($this->links[$name]);
    }

    /**
     * @param string $name
     * @param ResourceableInterface $resource
     */
    public function addEmbedded($name, ResourceableInterface $resource)
    {
        $this->embedded[$name] = $resource;
    }

    /**
     * @param string $name
     * @return HalResource|ResourceCollection
     * @throws NotFoundException
     */
    public function getEmbedded($name)
    {
        if (!$this->hasEmbedded($name)) {
            throw new NotFoundException(sprintf('embedded resource "%s" not found', $name), 1460663416);
        }
        return $this->embedded[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasEmbedded($name)
    {
        return isset($this->embedded[$name]);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];
        foreach ($this->embedded as $name => $resource) {
            /** @var ResourceableInterface $resource */
            $data['_embedded'][$name] = $resource->getData();
        }
        foreach ($this->links as $name => $link) {
            /** @var ResourceableInterface $resource */
            $data['_links'][$name] = $link;
        }
        return array_merge($this->properties, $data);
    }
}

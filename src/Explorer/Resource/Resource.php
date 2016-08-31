<?php
namespace Aeq\Hal\Explorer\Resource;

use Aeq\Hal\Exception\NotFoundException;
use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\EmbeddableInterface;
use Aeq\Hal\Explorer\Link\Link;
use Aeq\Hal\Explorer\Link\LinkCollection;
use Aeq\Hal\Explorer\Link\LinkInterface;

class Resource implements ResourceInterface, EmbeddableInterface
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
     * @var LinkInterface[]
     */
    private $links = [];

    /**
     * @var ResourceInterface[]
     */
    private $embedded = [];

    /**
     * @param Explorer $explorer
     * @param array $properties
     */
    public function __construct(Explorer $explorer, array $properties)
    {
        $this->explorer = $explorer;
        $this->properties = $properties;
    }

    /**
     * @param string $name
     * @return \Aeq\Hal\Explorer\Link\Link|\Aeq\Hal\Explorer\Link\LinkCollection
     * @throws NotFoundException
     */
    public function getLink($name)
    {
        if (!$this->hasLink($name)) {
            throw new NotFoundException(sprintf('link "%s" not found', $name), 1460663568);
        }
        return $this->links[$name];
    }

    /**
     * @param string $name
     * @param LinkInterface $link
     */
    public function addLink($name, LinkInterface $link)
    {
        $this->links[$name] = $link;
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
     * @param ResourceInterface $resource
     */
    public function addEmbedded($name, ResourceInterface $resource)
    {
        $this->embedded[$name] = $resource;
    }

    /**
     * @param string $name
     * @return ResourceInterface
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
            $data['_embedded'][$name] = $resource->getData();
        }
        foreach ($this->links as $name => $link) {
            $data['_links'][$name] = $link->getData();
        }
        return array_merge($this->properties, $data);
    }
}

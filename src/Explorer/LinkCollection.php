<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Exception\AlreadyEmbeddedException;
use Aeq\Hal\Explorer;

class LinkCollection implements \Iterator, LinkInterface, EmbeddableInterface
{
    /**
     * @var Explorer
     */
    private $explorer;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Link[]
     */
    private $links = [];

    /**
     * @var EmbeddableInterface
     */
    private $parent;

    /**
     * @var ResourceCollection
     */
    private $resources;

    /**
     * @param Explorer $explorer
     * @param string $name
     * @param EmbeddableInterface $parent
     */
    public function __construct(Explorer $explorer, $name, EmbeddableInterface $parent)
    {
        $this->explorer = $explorer;
        $this->name = $name;
        $this->parent = $parent;
        $this->resources = new ResourceCollection($explorer);
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        $this->links[] = $link;
    }

    /**
     * @return Link
     */
    public function current()
    {
        return current($this->links);
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->links);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->links);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->links) !== null;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->links);
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = [];
        foreach ($this->links as $link) {
            $data[] = $link->getData();
        }
        return $data;
    }

    /**
     * @param string $name
     * @param \Aeq\Hal\Explorer\ResourceInterface $resource
     */
    public function addEmbedded($name, ResourceInterface $resource)
    {
        $this->resources->addResource($resource);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasEmbedded($name)
    {
        return $this->parent->hasEmbedded($name);
    }

    /**
     * @param array $variables
     * @param array $options
     * @return ResourceCollection
     * @throws AlreadyEmbeddedException
     */
    public function follow(array $variables = [], array $options = [])
    {
        foreach ($this->links as $link) {
            $link->follow($variables, $options);
        }

        $this->parent->addEmbedded($this->name, $this->resources);

        return $this->resources;
    }
}

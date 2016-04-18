<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Exception\AlreadyEmbeddedException;
use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;

class LinkCollection extends AbstractLink implements \Iterator
{
    /**
     * @return HalResource
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->data) !== null;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->data);
    }

    /**
     * @param array $variables
     * @param array $options
     * @return ResourceCollection
     * @throws AlreadyEmbeddedException
     */
    public function follow(array $variables = [], array $options = [])
    {
        if ($this->parent->hasEmbedded($this->name)) {
            throw new AlreadyEmbeddedException(
                sprintf(
                    'A link "%s" is already embedded. Try getting the embedded resource and reload it.',
                    $this->name
                ),
                1460663789
            );
        }
        $resources = [];
        foreach ($this->data as $name => $link) {
            $resources[$name] = $this->request('GET', $link['href'], $variables, $options);
        }
        $resource = new ResourceCollection($this->explorer, $resources);
        $this->parent->addEmbedded($this->name, $resource);
        return $resource;
    }
}

<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;
use Aeq\Hal\Exception\AlreadyEmbeddedException;

class Link implements LinkInterface
{
    /**
     * @var Explorer
     */
    protected $explorer;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var EmbeddableInterface
     */
    protected $parent;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param Explorer $explorer
     * @param string $name
     * @param array $data
     * @param EmbeddableInterface $parent
     */
    public function __construct(Explorer $explorer, $name, array $data, EmbeddableInterface $parent)
    {
        $this->explorer = $explorer;
        $this->data = $data;
        $this->name = $name;
        $this->parent = $parent;
    }

    /**
     * @param array $variables
     * @param array $options
     * @return HalResource
     * @throws AlreadyEmbeddedException
     */
    public function follow(array $variables = [], array $options = [])
    {
        if ($this->parent->hasEmbedded($this->name)) {
            throw new AlreadyEmbeddedException(
                sprintf('A link "%s" is already embedded. Try getting the embedded resource and reload it.'),
                1460663670
            );
        }
        $resource = $this->request('GET', $this->data['href'], $variables, $options);
        $this->parent->addEmbedded($this->name, $resource);
        return $resource;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $variables
     * @param array $options
     * @return HalResource|\Aeq\Hal\Explorer\ResourceCollection
     */
    protected function request($method, $uri, array $variables = [], array $options = [])
    {
        $response = $this->explorer->request($method, $uri, $options);
        $resource = $this->explorer->explore($response);
        return $resource;
    }
}

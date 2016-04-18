<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;

abstract class AbstractLink
{
    /**
     * @var Explorer
     */
    protected $explorer;

    /**
     * @var HalResource
     */
    protected $parent;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param Explorer $explorer
     * @param string $name
     * @param array $data
     */
    public function __construct(Explorer $explorer, $name, array $data)
    {
        $this->explorer = $explorer;
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * @param array $variables
     * @param array $options
     * @return HalResource|ResourceCollection
     */
    abstract public function follow(array $variables = [], array $options = []);

    /**
     * @param string $method
     * @param string $uri
     * @param array $variables
     * @param array $options
     * @return HalResource|ResourceCollection
     */
    protected function request($method, $uri, array $variables = [], array $options = [])
    {
        $response = $this->explorer->request($method, $uri, $options);
        $resource = $this->explorer->explore($response);
        return $resource;
    }

    /**
     * @param ResourceableInterface $parent
     */
    public function setParent(ResourceableInterface $parent)
    {
        $this->parent = $parent;
    }
}

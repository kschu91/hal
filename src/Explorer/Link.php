<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;
use Aeq\Hal\Exception\AlreadyEmbeddedException;
use QL\UriTemplate\UriTemplate;

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

        $resource = $this->request($variables, $options);
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
     * @param array $variables
     * @param array $options
     * @return HalResource|ResourceCollection
     */
    private function request(array $variables = [], array $options = [])
    {
        $response = $this->explorer->request('GET', $this->getUri($variables), $options);
        $resource = $this->explorer->explore($response);
        return $resource;
    }

    /**
     * @param array $variables
     * @return string
     */
    private function getUri(array  $variables)
    {
        if (isset($this->data['templated']) && true === $this->data['templated']) {
            $uri = new UriTemplate($this->data['href']);
            return $uri->expand($variables);
        }
        return $this->data['href'];
    }
}

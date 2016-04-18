<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;
use Aeq\Hal\Exception\AlreadyEmbeddedException;

class Link extends AbstractLink
{
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
}

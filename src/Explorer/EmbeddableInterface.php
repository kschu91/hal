<?php
namespace Aeq\Hal\Explorer;

interface EmbeddableInterface
{
    /**
     * @param string $name
     * @param ResourceInterface $resource
     */
    public function addEmbedded($name, ResourceInterface $resource);

    /**
     * @param string $name
     * @return bool
     */
    public function hasEmbedded($name);
}

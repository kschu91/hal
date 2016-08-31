<?php
namespace Aeq\Hal\Explorer\Link;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\EmbeddableInterface;
use Aeq\Hal\Utils\ArrayUtils;

class LinkFactory
{
    /**
     * @param Explorer $explorer
     * @param string $name
     * @param array $data
     * @param EmbeddableInterface $parent
     * @return LinkInterface
     */
    public static function create(Explorer $explorer, $name, array $data, EmbeddableInterface $parent)
    {
        if (ArrayUtils::isNumericArray($data)) {
            return self::createCollection($explorer, $name, $data, $parent);
        }
        return self::createLink($explorer, $name, $data, $parent);
    }

    /**
     * @param Explorer $explorer
     * @param string $name
     * @param array $data
     * @param EmbeddableInterface $parent
     * @return Link
     */
    public static function createLink(Explorer $explorer, $name, array $data, EmbeddableInterface $parent)
    {
        return new Link($explorer, $name, $data, $parent);
    }

    /**
     * @param Explorer $explorer
     * @param string $name
     * @param array $data
     * @param EmbeddableInterface $parent
     * @return LinkCollection
     */
    public static function createCollection(Explorer $explorer, $name, array $data, EmbeddableInterface $parent)
    {
        $collection =  new LinkCollection($explorer, $name, $parent);
        foreach ($data as $itemData) {
            $collection->addLink(self::createLink($explorer, $name, $itemData, $collection));
        }
        return $collection;
    }
}

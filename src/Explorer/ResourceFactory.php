<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;
use Aeq\Hal\Utils\ArrayUtils;

class ResourceFactory
{
    /**
     * @param Explorer $explorer
     * @param array $data
     * @return HalResource|ResourceCollection
     */
    public static function create(Explorer $explorer, array $data)
    {
        if (ArrayUtils::isNumericArray($data)) {
            return self::createCollection($explorer, $data);
        }
        return self::createResource($explorer, $data);
    }

    /**
     * @param Explorer $explorer
     * @param array $data
     * @return ResourceCollection
     */
    private static function createCollection(Explorer $explorer, array $data)
    {
        $collection = new ResourceCollection($explorer);
        foreach ($data as $itemData) {
            $collection->addResource(self::create($explorer, $itemData));
        }
        return $collection;
    }

    /**
     * @param Explorer $explorer
     * @param array $data
     * @return HalResource
     */
    private static function createResource(Explorer $explorer, array $data)
    {
        $links = isset($data['_links']) ? $data['_links'] : [];
        $embedded = isset($data['_embedded']) ? $data['_embedded'] : [];

        unset($data['_links'], $data['_embedded']);

        $resource = new Resource($explorer, $data);

        self::parseEmbedded($explorer, $resource, $embedded);
        self::parseLinks($explorer, $resource, $links);

        return $resource;
    }

    /**
     * @param Explorer $explorer
     * @param EmbeddableInterface $resource
     * @param array $embedded
     */
    private static function parseEmbedded(Explorer $explorer, EmbeddableInterface $resource, array $embedded)
    {
        foreach ($embedded as $name => $embed) {
            $resource->addEmbedded($name, self::create($explorer, $embed));
        }
    }

    /**
     * @param Explorer $explorer
     * @param HalResource $resource
     * @param array $links
     */
    private static function parseLinks(Explorer $explorer, HalResource $resource, array $links)
    {
        foreach ($links as $name => $link) {
            $resource->addLink($name, LinkFactory::create($explorer, $name, $link, $resource));
        }
    }
}

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
        $collection = [];
        foreach ($data as $itemData) {
            $collection[] = self::create($explorer, $itemData);
        }
        return new ResourceCollection($explorer, $collection);
    }

    /**
     * @param Explorer $explorer
     * @param array $data
     * @return ResourceCollection
     */
    private static function createResource(Explorer $explorer, array $data)
    {
        $links = isset($data['_links']) ? $data['_links'] : [];
        $embedded = isset($data['_embedded']) ? $data['_embedded'] : [];

        unset($data['_links'], $data['_embedded']);

        return new Resource(
            $explorer,
            $data,
            self::parseLinks($explorer, $links),
            self::parseEmbedded($explorer, $embedded)
        );
    }

    /**
     * @param Explorer $explorer
     * @param array $embedded
     * @return array
     */
    private static function parseEmbedded(Explorer $explorer, array $embedded)
    {
        $parsed = [];
        foreach ($embedded as $name => $embed) {
            $parsed[$name] = self::create($explorer, $embed);
        }
        return $parsed;
    }

    /**
     * @param Explorer $explorer
     * @param array $links
     * @return array
     */
    private static function parseLinks(Explorer $explorer, array $links)
    {
        $parsed = [];
        foreach ($links as $name => $link) {
            $parsed[$name] = LinkFactory::create($explorer, $name, $link);
        }
        return $parsed;
    }
}

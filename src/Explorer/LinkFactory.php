<?php
namespace Aeq\Hal\Explorer;

use Aeq\Hal\Explorer;
use Aeq\Hal\Explorer\Resource as HalResource;
use Aeq\Hal\Utils\ArrayUtils;

class LinkFactory
{
    /**
     * @param Explorer $explorer
     * @param string $name
     * @param array $data
     * @param array $options
     * @return Link|LinkCollection
     */
    public static function create(Explorer $explorer, $name, array $data, array $options = [])
    {
        if (ArrayUtils::isNumericArray($data)) {
            return new LinkCollection($explorer, $name, $data, $options);
        }
        return new Link($explorer, $name, $data, $options);
    }
}

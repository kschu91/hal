<?php
namespace Aeq\Hal\Serializer;

interface SerializerInterface
{
    /**
     * @param object|array $data
     * @return string
     */
    public function serialize($data);

    /**
     * @param string $str
     * @return array
     */
    public function deserialize($str);
}

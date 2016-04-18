<?php
namespace Aeq\Hal\Serializer;

class JsonSerializer implements SerializerInterface
{
    /**
     * @param object|array $data
     * @return string
     */
    public function serialize($data)
    {
        return json_encode($data);
    }

    /**
     * @param string $str
     * @return array
     */
    public function deserialize($str)
    {
        return @json_decode($str, true);
    }
}

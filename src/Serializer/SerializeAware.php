<?php
namespace Aeq\Hal\Serializer;

trait SerializeAware
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param object|array $data
     * @return string
     */
    public function serialize($data)
    {
        if ($this->serializer instanceof SerializerInterface) {
            return $this->serializer->serialize($data);
        }
        throw new \LogicException(sprintf('no client adapter set for "%s"', __CLASS__), 1460016545);
    }

    /**
     * @param string $str
     * @return array
     */
    public function deserialize($str)
    {
        if ($this->serializer instanceof SerializerInterface) {
            return $this->serializer->deserialize($str);
        }
        throw new \LogicException(sprintf('no client adapter set for "%s"', __CLASS__), 1460016579);
    }

    /**
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
}

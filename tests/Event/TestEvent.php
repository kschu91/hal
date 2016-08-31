<?php
namespace Aeq\Hal\Event;

class TestEvent implements EventInterface
{
    /**
     * @var string
     */
    private $foo;

    /**
     * @param string $foo
     */
    public function __construct($foo)
    {
        $this->foo = $foo;
    }

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }
}

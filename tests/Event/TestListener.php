<?php
namespace Aeq\Hal\Event;

class TestListener
{
    /**
     * @var TestEvent
     */
    private $event;

    /**
     * @param TestEvent $event
     */
    public function handle(TestEvent $event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getFoo()
    {
        return $this->event->getFoo();
    }
}

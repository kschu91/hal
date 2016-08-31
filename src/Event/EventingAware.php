<?php
namespace Aeq\Hal\Event;

trait EventingAware
{
    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @param EventInterface $event
     */
    public function triggerEvent(EventInterface $event)
    {
        if ($this->eventManager instanceof EventManager) {
            $this->eventManager->trigger($event);
        }
    }

    /**
     * @param string $event
     * @param string $listener
     */
    public function listenOnEvent($event, $listener)
    {
        if ($this->eventManager instanceof EventManager) {
            $this->eventManager->listen($event, $listener);
        }
    }

    /**
     * @param EventManager $eventManager
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->eventManager = $eventManager;
    }
}

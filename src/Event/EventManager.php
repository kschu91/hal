<?php
namespace Aeq\Hal\Event;

use Aeq\Hal\Event\Exception\InvalidListenerException;

class EventManager
{
    /**
     * @var array
     */
    private static $listeners = [];

    /**
     * @param EventInterface $event
     */
    public function trigger(EventInterface $event)
    {
        foreach (self::$listeners as $listener) {
            list($registeredEvent, $registeredListener) = $listener;
            if (get_class($event) === $registeredEvent) {
                call_user_func_array([$registeredListener, 'handle'], [$event]);
            }
        }
    }

    /**
     * @param string $event
     * @param string $listener
     */
    public function listen($event, $listener)
    {
        if (!$this->isValidListener($listener)) {
            throw new InvalidListenerException(
                sprintf('Listener "%s" not valid. Listener should be a POPO object with a "handle" method', $listener),
                1472634731
            );
        }
        self::$listeners[] = [
            $event,
            $listener
        ];
    }

    /**
     * @param string $listener
     * @return bool
     */
    private function isValidListener($listener)
    {
        if (is_callable([$listener, 'handle'])) {
            return true;
        }
        return false;
    }
}

<?php
namespace Aeq\Hal\Event;

use Aeq\Hal\Explorer;

class EventingAwareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotTriggerEventIfEventManagerNotSet()
    {
        /** @var EventingAware|\PHPUnit_Framework_MockObject_MockObject $eventingAware */
        $eventingAware = $this->getMockBuilder(EventingAware::class)
            ->getMockForTrait();

        $eventingAware->triggerEvent(new TestEvent('bar'));
    }
    /**
     * @test
     */
    public function shouldTriggerEvent()
    {
        /** @var EventManager|\PHPUnit_Framework_MockObject_MockObject $eventManager */
        $eventManager = $this->getMockBuilder(EventManager::class)
            ->setMethods(['trigger'])
            ->getMock();
        $eventManager->expects($this->once())->method('trigger')->with(new TestEvent('bar'));

        /** @var EventingAware|\PHPUnit_Framework_MockObject_MockObject $eventingAware */
        $eventingAware = $this->getMockBuilder(EventingAware::class)
            ->getMockForTrait();
        $eventingAware->setEventManager($eventManager);

        $eventingAware->triggerEvent(new TestEvent('bar'));
    }

    /**
     * @test
     */
    public function shouldNotListenOnEventIfEventManagerNotSet()
    {
        /** @var EventingAware|\PHPUnit_Framework_MockObject_MockObject $eventingAware */
        $eventingAware = $this->getMockBuilder(EventingAware::class)
            ->getMockForTrait();

        $eventingAware->listenOnEvent('foo', 'bar');
    }

    /**
     * @test
     */
    public function shouldListenOnEvent()
    {
        /** @var EventManager|\PHPUnit_Framework_MockObject_MockObject $eventManager */
        $eventManager = $this->getMockBuilder(EventManager::class)
            ->setMethods(['listen'])
            ->getMock();
        $eventManager->expects($this->once())->method('listen')->with('foo', 'bar');

        /** @var EventingAware|\PHPUnit_Framework_MockObject_MockObject $eventingAware */
        $eventingAware = $this->getMockBuilder(EventingAware::class)
            ->getMockForTrait();
        $eventingAware->setEventManager($eventManager);

        $eventingAware->listenOnEvent('foo', 'bar');
    }
}

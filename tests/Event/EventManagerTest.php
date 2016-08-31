<?php
namespace Aeq\Hal\Event;

class EventManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldListen()
    {
        $testListener = new TestListener();

        $eventManager = new EventManager();
        $eventManager->listen(TestEvent::class, $testListener);

        $eventManager->trigger(new TestEvent('bar'));

        $this->assertSame('bar', $testListener->getFoo());
    }
    
    /**
     * @test
     *
     * @expectedException \Aeq\Hal\Event\Exception\InvalidListenerException
     * @expectedExceptionCode 1472634731
     */
    public function shouldFailOnInvalidListener()
    {
        $eventManager = new EventManager();
        $eventManager->listen(TestEvent::class, 'nonExistingListener');
    }
}

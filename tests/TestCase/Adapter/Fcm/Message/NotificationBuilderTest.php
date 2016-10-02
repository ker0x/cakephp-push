<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\TestSuite\TestCase;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException;
use ker0x\Push\Adapter\Fcm\Message\NotificationBuilder;

class NotificationBuilderTest extends TestCase
{
    private $notificationBuilder;

    public function setUp()
    {
        $this->notificationBuilder = new NotificationBuilder('title');
    }

    public function testInvalidColor()
    {
        $this->expectException(InvalidNotificationException::class);
        $this->notificationBuilder->setColor('color');
    }

    public function testIsString()
    {
        $this->expectException(InvalidNotificationException::class);
        $this->notificationBuilder->setBody(12345);
    }

    public function tearDown()
    {
        unset($this->notificationBuilder);
    }
}

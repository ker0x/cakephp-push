<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\TestSuite\TestCase;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException;
use ker0x\Push\Adapter\Fcm\Message\OptionsBuilder;

class OptionsBuilderTest extends TestCase
{
    private $optionBuilder;

    public function setUp()
    {
        $this->optionBuilder = new OptionsBuilder();
    }

    public function testInvalidTimeToLive()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setTimeToLive(2419201);
    }

    public function testInvalidPriority()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setPriority('low');
    }

    public function tearDown()
    {
        unset($this->optionBuilder);
    }
}

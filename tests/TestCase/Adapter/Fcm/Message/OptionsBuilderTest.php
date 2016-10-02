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

    public function testInvalidCollapseKey()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setCollapseKey(true);
    }

    public function testInvalidPriority()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setPriority('low');
    }

    public function testInvalidContentAvailable()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setContentAvailable('true');
    }

    public function testInvalidTimeToLive()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setTimeToLive(2419201);
    }

    public function testInvalidRestrictedPackageName()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setRestrictedPackageName(true);
    }

    public function testInvalidDryRun()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->optionBuilder->setDryRun('true');
    }

    public function tearDown()
    {
        unset($this->optionBuilder);
    }
}

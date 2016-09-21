<?php
namespace ker0x\Push\Test\TestCase;

use Cake\TestSuite\IntegrationTestCase;
use ker0x\Push\Adapter\FcmAdapter;
use ker0x\Push\Exception\InvalidAdapterException;
use ker0x\Push\Exception\InvalidDataException;
use ker0x\Push\Exception\InvalidNotificationException;
use ker0x\Push\Exception\InvalidParametersException;
use ker0x\Push\Exception\InvalidTokenException;

class FcmTest extends IntegrationTestCase
{
    public $adapter;

    public $push;

    public $tokens;

    public function setUp()
    {
        $this->adapter = new FcmAdapter();
    }

    public function testEmptyTokens()
    {
        $this->expectException(InvalidTokenException::class);
        $this->adapter->setTokens([]);
    }

    public function testToManyTokens()
    {
        $tokens = [];
        for ($i = 1; $i <= 1001; $i++) {
            $tokens[] = $i;
        }

        $this->expectException(InvalidTokenException::class);
        $this->adapter->setTokens($tokens);
    }

    public function testGetTokens()
    {
        $this->adapter->setTokens([1, 2, 3]);
        $tokens = $this->adapter->getTokens();

        $this->assertEquals([1, 2, 3], $tokens);
    }

    public function testEmptyNotification()
    {
        $this->expectException(InvalidNotificationException::class);
        $this->adapter->setNotification([]);
    }

    public function testKeysNotification()
    {
        $exceptionMessage = null;
        $notification = [
            'title' => 'Hello world',
            'foo' => 'bar',
            'bar' => 'foo',
        ];

        try {
            $this->adapter->setNotification($notification);
        } catch (InvalidNotificationException $e) {
            $exceptionMessage = $e->getMessage();
        }

        $this->assertEquals("The following keys are not allowed: foo, bar", $exceptionMessage);
    }

    public function testGetNotification()
    {
        $this->adapter->setNotification(['title' => 'Hello world']);
        $notification = $this->adapter->getNotification();

        $this->assertEquals(['title' => 'Hello world', 'icon' => 'myicon'], $notification);
    }

    public function testEmptyDatas()
    {
        $this->expectException(InvalidDataException::class);
        $this->adapter->setDatas([]);
    }

    public function testGetDatas()
    {
        $this->adapter->setDatas([
            'data-1' => 'Lorem ipsum',
            'data-2' => 1234,
            'data-3' => true,
            'data-4' => false,
        ]);
        $datas = $this->adapter->getDatas();

        $this->assertEquals([
            'data-1' => 'Lorem ipsum',
            'data-2' => '1234',
            'data-3' => 'true',
            'data-4' => 'false'
        ], $datas);
    }

    public function testEmptyParameters()
    {
        $this->expectException(InvalidParametersException::class);
        $this->adapter->setParameters([]);
    }

    public function testGetParameters()
    {
        $this->adapter->setParameters([
            'dry_run' => true,
        ]);
        $parameters = $this->adapter->getParameters();

        $this->assertEquals([
            'collapse_key' => null,
            'priority' => 'normal',
            'dry_run' => true,
            'time_to_live' => 0,
            'restricted_package_name' => null
        ], $parameters);
    }

    public function tearDown()
    {
        unset($this->adapter);
    }
}

<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\TestSuite\TestCase;
use ker0x\Push\Adapter\Fcm\Message\DataBuilder;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException;

class DataBuilderTest extends TestCase
{
    private $dataBuilder;

    public function setUp()
    {
        $this->dataBuilder = new DataBuilder();
    }

    public function testRemoveData()
    {
        $this->dataBuilder
            ->addData('data-1', 'data-1')
            ->addData('data-2', true)
            ->addData('data-3', 1234)
            ->removeData('data-1');

        $data = $this->dataBuilder->getAllData();

        $this->assertEquals([
            'data-2' => 'true',
            'data-3' => '1234',
        ], $data);
    }

    public function testRemoveAllData()
    {
        $this->dataBuilder
            ->addData('data-1', 'data-1')
            ->addData('data-2', true)
            ->addData('data-3', 1234)
            ->removeAllData();

        $data = $this->dataBuilder->getAllData();

        $this->assertEquals([], $data);
    }

    public function testGetData()
    {
        $this->dataBuilder
            ->addData('data-1', 'data-1')
            ->addData('data-2', true)
            ->addData('data-3', 1234);

        $data2 = $this->dataBuilder->getData('data-2');

        $this->assertEquals('true', $data2);
    }

    public function testGetNoneExistentData()
    {
        $this->expectException(InvalidDataException::class);
        $this->dataBuilder
            ->addData('data-1', 'data-1')
            ->addData('data-2', true)
            ->addData('data-3', 1234);

        $data4 = $this->dataBuilder->getData('data-4');
    }

    public function tearDown()
    {
        unset($this->dataBuilder);
    }
}
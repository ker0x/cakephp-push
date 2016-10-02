<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\TestSuite\TestCase;
use ker0x\Push\Adapter\Fcm\Message\Data;
use ker0x\Push\Adapter\Fcm\Message\DataBuilder;

class DataTest extends TestCase
{
    public function testDataFromDataBuilder()
    {
        $dataBuilder = new DataBuilder();
        $dataBuilder
            ->addData('data-1', 'data-1')
            ->addData('data-2', true)
            ->addData('data-3', 1234);

        $data = new Data($dataBuilder);
        $data = $data->build();

        $this->assertEquals([
            'data-1' => 'data-1',
            'data-2' => 'true',
            'data-3' => '1234',
        ], $data);
    }

    public function testDataFromArray()
    {
        $data = new Data([
            'data-1' => 'data-1',
            'data-2' => true,
            'data-3' => 1234,
        ]);
        $data = $data->build();

        $this->assertEquals([
            'data-1' => 'data-1',
            'data-2' => 'true',
            'data-3' => '1234',
        ], $data);
    }
}
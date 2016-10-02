<?php
namespace ker0x\Push\Adapter\Fcm\Message;

use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException;

class Data implements BuilderInterface
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Data constructor.
     *
     * @param array|\ker0x\Push\Adapter\Fcm\Message\DataBuilder $dataBuilder
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException
     */
    public function __construct($dataBuilder)
    {
        if (is_array($dataBuilder)) {
            $dataBuilder = $this->fromArray($dataBuilder);
        }

        $this->data = $dataBuilder->getAllData();
    }

    /**
     * @return array
     */
    public function build(): array
    {
        return $this->data;
    }

    /**
     * Build data from an array.
     *
     * @param array $dataArray
     * @return \ker0x\Push\Adapter\Fcm\Message\DataBuilder
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException
     */
    private function fromArray(array $dataArray)
    {
        if (empty($dataArray)) {
            throw InvalidDataException::arrayEmpty();
        }

        $dataBuilder = new DataBuilder();
        foreach ($dataArray as $key => $value) {
            $dataBuilder->addData($key, $value);
        }

        return $dataBuilder;
    }
}
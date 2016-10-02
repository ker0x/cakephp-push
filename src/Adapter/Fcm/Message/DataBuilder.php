<?php
namespace ker0x\Push\Adapter\Fcm\Message;

use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException;

class DataBuilder
{

    /**
     * An array of data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Setter for data.
     *
     * @param string $key
     * @param $value
     * @return \ker0x\Push\Adapter\Fcm\Message\DataBuilder
     */
    public function addData($key, $value)
    {
        if (is_bool($value)) {
            $value = ($value) ? 'true' : 'false';
        }
        $this->data[$key] = (string)$value;

        return $this;
    }

    /**
     * Getter for data.
     *
     * @param string $key
     * @return mixed
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException
     */
    public function getData($key)
    {
        if (!array_key_exists($key, $this->data)) {
            throw InvalidDataException::invalidKey($key);
        }
        return $this->data[$key];
    }

    /**
     * Return all data.
     *
     * @return array|null
     */
    public function getAllData(): array
    {
        return $this->data;
    }

    /**
     * Remove the data with the key $key.
     *
     * @param string $key
     * @return \ker0x\Push\Adapter\Fcm\Message\DataBuilder
     */
    public function removeData($key)
    {
        unset($this->data[$key]);

        return $this;
    }

    /**
     * Remove all data
     *
     * @return void
     */
    public function removeAllData()
    {
        $this->data = [];
    }
}
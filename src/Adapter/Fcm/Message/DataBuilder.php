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
     * @param string $key The data key.
     * @param string|bool|int $value The data value.
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
     * @param string $key The key we want to get.
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
     * @return array
     */
    public function getAllData()
    {
        return $this->data;
    }

    /**
     * Remove the data with the key $key.
     *
     * @param string $key The key we want to remove.
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

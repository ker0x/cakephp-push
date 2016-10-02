<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

class InvalidDataException extends AbstractException
{

    /**
     * Display if a key does not exist in an array
     *
     * @param string $key The key that is wrong.
     * @return static
     */
    public static function invalidKey($key)
    {
        return new static(sprintf("%s does not exist in array data.", $key));
    }
}

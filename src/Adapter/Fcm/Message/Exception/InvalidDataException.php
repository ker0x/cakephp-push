<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

class InvalidDataException extends AbstractException
{

    public static function invalidKey($key)
    {
        return new static(sprintf("%s does not exist in array data.", $key));
    }
}

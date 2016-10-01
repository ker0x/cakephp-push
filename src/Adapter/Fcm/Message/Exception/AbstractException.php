<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

use Exception;

abstract class AbstractException extends Exception
{
    public static function mustBeString($key)
    {
        return new static("{$key} must be a string.");
    }

    public static function mustBeBool($key)
    {
        return new static("{$key} must be a boolean.");
    }

    public static function mustBeInt($key)
    {
        return new static("{$key} must be a integer.");
    }

    public static function arrayEmpty()
    {
        return new static("Array can not be empty.");
    }
}
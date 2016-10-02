<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

use Exception;

abstract class AbstractException extends Exception
{

    /**
     * Display if the value must be a string.
     *
     * @param string $key The key that is wrong.
     * @return static
     */
    public static function mustBeString($key)
    {
        return new static(sprintf("%s must be a string.", $key));
    }

    /**
     * Display if the value must be a bool.
     *
     * @param string $key The key that is wrong.
     * @return static
     */
    public static function mustBeBool($key)
    {
        return new static(sprintf("%s must be a boolean.", $key));
    }

    /**
     * Display if the value must be an int.
     *
     * @param string $key The key that is wrong.
     * @return static
     */
    public static function mustBeInt($key)
    {
        return new static(sprintf("%s must be an integer.", $key));
    }

    /**
     * Display if an array is empty.
     *
     * @return static
     */
    public static function arrayEmpty()
    {
        return new static("Array can not be empty.");
    }
}

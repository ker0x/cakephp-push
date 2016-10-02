<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

use Exception;

abstract class AbstractException extends Exception
{

    /**
     *
     *
     * @param string $key
     * @return static
     */
    public static function mustBeString($key)
    {
        return new static(sprintf("%s must be a string.", $key));
    }

    /**
     * @param $key
     * @return static
     */
    public static function mustBeBool($key)
    {
        return new static(sprintf("%s must be a boolean.", $key));
    }

    /**
     * @param $key
     * @return static
     */
    public static function mustBeInt($key)
    {
        return new static(sprintf("%s must be an integer.", $key));
    }

    /**
     * @return static
     */
    public static function arrayEmpty()
    {
        return new static("Array can not be empty.");
    }
}

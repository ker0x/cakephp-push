<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

class InvalidNotificationException extends AbstractException
{

    /**
     * Display if the color is not in #rrggbb format.
     *
     * @return static
     */
    public static function invalidColor()
    {
        return new static("The color must be expressed in #rrggbb format.");
    }

    /**
     * Display if key `title` is missing.
     *
     * @return static
     */
    public static function invalidArray()
    {
        return new static("Notification array must contain at least a key 'title'.");
    }
}

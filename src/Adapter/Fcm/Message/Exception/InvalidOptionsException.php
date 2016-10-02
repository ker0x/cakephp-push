<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

class InvalidOptionsException extends AbstractException
{

    /**
     * Display if the TTL is incorrect
     *
     * @param string $value The value that is wrong.
     * @return static
     */
    public static function invalidTimeToLive($value)
    {
        return new static(sprintf("Time to live must be between 0 and 2419200. Current value is: %s.", $value));
    }

    /**
     * Display if the priority is incorrect.
     *
     * @return static
     */
    public static function invalidPriority()
    {
        return new static("Priority can be either 'normal' or 'high'.");
    }
}

<?php
namespace ker0x\Push\Adapter\Fcm\Message\Exception;

class InvalidOptionsException extends AbstractException
{
    public static function invalidTTL($value)
    {
        return new static("time_to_live must be a integer between 0 and 2419200. Current value is: {$value}");
    }
}

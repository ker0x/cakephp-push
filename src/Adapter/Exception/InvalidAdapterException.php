<?php
namespace ker0x\Push\Adapter\Exception;

use Exception;

class InvalidAdapterException extends Exception
{
    public static function noApiKey()
    {
        return new static("There is no API key set.");
    }
}

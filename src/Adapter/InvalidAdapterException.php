<?php
namespace ker0x\Push\Adapter;

use Exception;

class InvalidAdapterException extends Exception
{

    /**
     * Display if no API key is provide.
     *
     * @return static
     */
    public static function noApiKey()
    {
        return new static("There is no API key set.");
    }
}

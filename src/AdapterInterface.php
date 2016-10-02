<?php
namespace ker0x\Push;

/**
 * Interface AdapterInterface
 * @package ker0x\Push
 */
interface AdapterInterface
{

    /**
     * Return the url of the API
     *
     * @return string
     */
    public function getApiUrl();

    /**
     * The data you want to send.
     *
     * @return mixed
     */
    public function getHttpData();

    /**
     * Options for the request.
     *
     * @return array
     */
    public function getHttpOptions();
}

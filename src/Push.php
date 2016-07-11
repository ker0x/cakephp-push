<?php

namespace ker0x\Push;

class Push
{

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Constructor
     *
     * @param AdapterInterface $adapter [description]
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get the Adapter.
     *
     * @return AdapterInterface adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Send a downstream message to one or more devices.
     *
     * @param  mixed $ids Devices'ids
     * @param  array $payload The notification and/or some datas
     * @param  array $parameters Parameters for the request
     *
     * @return bool
     */
    public function send($ids = null, array $payload = [], array $parameters = [])
    {
        return $this->getAdapter()->send($ids, $payload, $parameters);
    }

    /**
     * Return the response of the push
     *
     * @return string
     */
    public function response()
    {
        return $this->getAdapter()->response();
    }

}

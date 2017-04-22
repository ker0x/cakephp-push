<?php

namespace ker0x\Push;

class Push
{

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * Constructor.
     *
     * @param AdapterInterface $adapter The adapter
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
     * @return bool
     */
    public function send()
    {
        return $this->getAdapter()->send();
    }

    /**
     * Return the response of the push.
     *
     * @return string
     */
    public function response()
    {
        return $this->getAdapter()->response();
    }
}

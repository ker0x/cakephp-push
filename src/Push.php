<?php

namespace ker0x\Push;

use Cake\Core\InstanceConfigTrait;
use Cake\Network\Http\Client;

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
     * @param  mixed $tokens Device's token
     * @param  array $payload The notification and/or some datas
     * @param  array $parameters Parameters for the request
     *
     * @return bool
     */
    public function send($tokens = null, array $payload = [], array $parameters = [])
    {
        return $this->getAdapter()->send($tokens, $payload, $parameters);
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

<?php

namespace Kerox\Push;

class Push {

    /**
     * @var \Kerox\Push\AdapterInterface
     */
    protected $adapter;

    /**
     * Constructor.
     *
     * @param \Kerox\Push\AdapterInterface $adapter The adapter
     */
    public function __construct(AdapterInterface $adapter) {
        $this->adapter = $adapter;
    }

    /**
     * Get the Adapter.
     *
     * @return \Kerox\Push\AdapterInterface adapter
     */
    public function getAdapter() {
        return $this->adapter;
    }

    /**
     * Send a downstream message to one or more devices.
     *
     * @return bool
     */
    public function send() {
        return $this->getAdapter()->send();
    }

    /**
     * Return the response of the push.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function response() {
        return $this->getAdapter()->response();
    }

}

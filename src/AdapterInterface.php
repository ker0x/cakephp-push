<?php

namespace ker0x\Push;

interface AdapterInterface
{

    /**
     * Send a downstream message to one or more devices.
     *
     * @return bool
     */
    public function send();

    /**
     * Return the response of the push
     *
     * @return mixed
     */
    public function response();
}

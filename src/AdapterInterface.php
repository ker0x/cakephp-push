<?php

namespace ker0x\Push;

interface AdapterInterface
{

    /**
     * Send a downstream message to one or more devices.
     *
     * @param  mixed $ids Devices'ids
     * @param  array $payload The notification and/or some datas
     * @param  array $parameters Parameters for the request
     *
     * @return bool
     */
    public function send($ids, array $payload, array $parameters);

    /**
     * Return the response of the push
     *
     * @return string
     */
    public function response();

}

<?php

namespace Kerox\Push;

interface AdapterInterface {

    /**
     * Send a request
     *
     * @return bool
     */
    public function send();

    /**
     * Return the response of the request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function response();

}

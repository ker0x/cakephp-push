<?php
namespace ker0x\Push\Adapter;

use ker0x\Push\AdapterInterface;
use ker0x\Push\Adapter\Fcm\Fcm;

class FcmAdapter extends Fcm implements AdapterInterface
{

    /**
     * Send the request
     *
     * @return bool
     */
    public function send()
    {
        return $this->_executePush();
    }

    /**
     * Display the response of the request
     *
     * @return \Cake\Http\Client\Response
     */
    public function response()
    {
        return $this->response;
    }
}

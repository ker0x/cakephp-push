<?php
namespace ker0x\Push\Adapter;

use ker0x\Push\AdapterInterface;
use ker0x\Push\Adapter\Fcm\Fcm;

/**
 * Class FcmAdapter
 * @package ker0x\Push\Adapter
 */
class FcmAdapter extends Fcm implements AdapterInterface
{

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->config('api.url');
    }

    /**
     * @return string
     */
    public function getHttpData()
    {
        return $this->_getMessage();
    }

    /**
     * @return array
     */
    public function getHttpOptions()
    {
        return $this->_getHttpOptions();
    }
}

<?php
namespace ker0x\Push;

use Cake\Http\Client;

class Push
{

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    protected $response;

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
        $url = $this->getAdapter()->getApiUrl();
        $data = $this->getAdapter()->getHttpData();
        $options = $this->getAdapter()->getHttpOptions();

        $http = new Client();
        $this->response = $http->post($url, $data, $options);

        return $this->response->code === '200';
    }

    /**
     * Return the response of the push.
     *
     * @return string
     */
    public function response()
    {
        return $this->response;
    }
}

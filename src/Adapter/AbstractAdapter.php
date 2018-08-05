<?php

namespace Kerox\Push\Adapter;

use Cake\Core\InstanceConfigTrait;
use Kerox\Push\AdapterInterface;

abstract class AbstractAdapter implements AdapterInterface
{
    use InstanceConfigTrait;

    /**
     * Response of the request
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * AbstractAdapter constructor.
     *
     * @param string|array $config The Adapter configuration
     *
     * @throws \Exception
     */
    public function __construct($config)
    {
        $this->setConfig($config);

        if ($this->getConfig('api.key') === null) {
            throw new \InvalidArgumentException('No API key set.');
        }
    }

    /**
     * @inheritdoc
     */
    abstract public function send();

    /**
     * @inheritdoc
     */
    public function response()
    {
        return $this->response;
    }
}

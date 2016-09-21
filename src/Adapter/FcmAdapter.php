<?php
namespace ker0x\Push\Adapter;

use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
use Cake\Http\Client;
use Cake\Utility\Hash;
use ker0x\Push\AdapterInterface;
use kerox\Push\Exception\InvalidAdapterException;
use ker0x\Push\Exception\InvalidDataException;
use ker0x\Push\Exception\InvalidNotificationException;
use ker0x\Push\Exception\InvalidParametersException;
use ker0x\Push\Exception\InvalidTokenException;

class FcmAdapter implements AdapterInterface
{

    use InstanceConfigTrait;

    /**
     * @var array
     */
    protected $tokens = [];

    /**
     * @var array
     */
    protected $notification = [];

    /**
     * @var array
     */
    protected $datas = [];

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Default config
     *
     * @var array
     */
    protected $_defaultConfig = [
        'parameters' => [
            'collapse_key' => null,
            'priority' => 'normal',
            'dry_run' => false,
            'time_to_live' => 0,
            'restricted_package_name' => null
        ],
        'http' => []
    ];

    /**
     * List of keys allowed to be used in notification array.
     *
     * @var array
     */
    protected $_allowedNotificationParameters = [
        'title',
        'body',
        'icon',
        'sound',
        'badge',
        'tag',
        'color',
        'click_action',
        'body_loc_key',
        'body_loc_args',
        'title_loc_key',
        'title_loc_args',
    ];

    /**
     * FcmAdapter constructor.
     * @param array $config
     * @throws \kerox\Push\Exception\InvalidAdapterException
     */
    public function __construct(array $config = [])
    {
        $config = Configure::read('Push.adapters.Fcm');
        $this->config($config);

        if ($this->config('api.key') === null) {
            throw new InvalidAdapterException("No API key set. Push not triggered");
        }
    }

    /**
     * @return bool
     */
    public function send()
    {
        return $this->_executePush();
    }

    /**
     *
     */
    public function response()
    {
        // TODO: Implement response() method.
    }

    /**
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @param array $tokens
     * @return $this
     */
    public function setTokens(array $tokens)
    {
        $this->_checkTokens($tokens);
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * @return array
     */
    public function getNotification(): array
    {
        return $this->notification;
    }

    /**
     * @param array $notification
     * @return $this
     */
    public function setNotification(array $notification)
    {
        $this->_checkNotification($notification);
        if (!isset($notification['icon'])) {
            $notification['icon'] = 'myicon';
        }
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        return $this->datas;
    }

    /**
     * @param array $datas
     * @return $this
     */
    public function setDatas(array $datas)
    {
        $this->_checkDatas($datas);
        foreach ($datas as $key => $value) {
            if (is_bool($value)) {
                $value = ($value) ? 'true' : 'false';
            }
            $datas[$key] = (string)$value;
        }
        $this->datas = $datas;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->_checkParameters($parameters);
        $this->parameters = Hash::merge($this->config('parameters'), $parameters);

        return $this;
    }

    /**
     * @param $tokens
     * @return void
     * @throws \ker0x\Push\Exception\InvalidTokenException
     */
    private function _checkTokens($tokens)
    {
        if (empty($tokens) || count($tokens) > 1000) {
            throw new InvalidTokenException("Array must contain at least 1 and at most 1000 tokens.");
        }
    }

    /**
     * @param $notification
     * @return void
     * @throws \ker0x\Push\Exception\InvalidNotificationException
     */
    private function _checkNotification($notification)
    {
        if (empty($notification) || !isset($notification['title'])) {
            throw new InvalidNotificationException("Array must contain at least a key title.");
        }

        $notAllowedKeys = [];
        foreach ($notification as $key => $value) {
            if (!in_array($key, $this->_allowedNotificationParameters)) {
                $notAllowedKeys[] = $key;
            }
        }

        if (!empty($notAllowedKeys)) {
            $notAllowedKeys = implode(', ', $notAllowedKeys);
            throw new InvalidNotificationException("The following keys are not allowed: {$notAllowedKeys}");
        }
    }

    /**
     * @param $datas
     * @return void
     * @throws \ker0x\Push\Exception\InvalidDataException
     */
    private function _checkDatas($datas)
    {
        if (empty($datas)) {
            throw new InvalidDataException("Array can not be empty.");
        }
    }

    /**
     * @param $parameters
     * @return void
     * @throws \ker0x\Push\Exception\InvalidParametersException
     */
    private function _checkParameters($parameters)
    {
        if (empty($parameters)) {
            throw new InvalidParametersException("Array can not be empty.");
        }
    }

    /**
     * @return bool
     */
    private function _executePush()
    {
        $message = $this->_buildMessage();
        $options = $this->_getHttpOptions();

        $http = new Client();
        $this->_response = $http->post($this->config('api.url'), $message, $options);

        return ($this->_response->code === '200') ? true : false;
    }

    /**
     *
     */
    private function _buildPayload()
    {
        $notification = $this->getNotification();
        if (!empty($notification)) {
            $this->payload['notification'] = $notification;
        }

        $datas = $this->getDatas();
        if (!empty($datas)) {
            $this->payload['datas'] = $datas;
        }
    }

    /**
     *
     */
    private function _buildMessage()
    {
        $tokens = $this->getTokens();
        $message = (count($tokens) > 1) ? ['registration_ids' => $tokens] : ['to' => current($tokens)];

        if (!empty($this->payload)) {
            $message += $this->payload;
        }

        $parameters = $this->getParameters();
        if (!empty($parameters)) {
            $message += $parameters;
        }

        return json_encode($message);
    }

    /**
     * Return options for the HTTP request
     *
     * @throws \Exception
     * @return array $options
     */
    private function _getHttpOptions()
    {
        $options = Hash::merge($this->config('http'), [
            'type' => 'json',
            'headers' => [
                'Authorization' => 'key=' . $this->config('api.key'),
                'Content-Type' => 'application/json'
            ]
        ]);

        return $options;
    }
}

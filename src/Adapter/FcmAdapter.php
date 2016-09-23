<?php
namespace ker0x\Push\Adapter;

use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
use Cake\Http\Client;
use Cake\Utility\Hash;
use ker0x\Push\AdapterInterface;
use ker0x\Push\Exception\InvalidAdapterException;
use ker0x\Push\Exception\InvalidDataException;
use ker0x\Push\Exception\InvalidNotificationException;
use ker0x\Push\Exception\InvalidParametersException;
use ker0x\Push\Exception\InvalidTokenException;

class FcmAdapter implements AdapterInterface
{

    use InstanceConfigTrait;

    /**
     * Array for devices's token
     *
     * @var array
     */
    protected $tokens = [];

    /**
     * Array for the notification
     *
     * @var array
     */
    protected $notification = [];

    /**
     * Array of datas
     *
     * @var array
     */
    protected $datas = [];

    /**
     * Array of request parameters
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * Array of payload
     *
     * @var array
     */
    protected $payload = [];

    /**
     * Response of the request
     *
     * @var \Cake\Http\Client\Response
     */
    protected $response;

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
    protected $_allowedNotificationKeys = [
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
     *
     * @throws \ker0x\Push\Exception\InvalidAdapterException
     */
    public function __construct()
    {
        $config = Configure::read('Push.adapters.Fcm');
        $this->config($config);

        if ($this->config('api.key') === null) {
            throw new InvalidAdapterException("No API key set. Push not triggered");
        }
    }

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
     * @return array
     */
    public function response()
    {
        return $this->response->json;
    }

    /**
     * Getter for tokens
     *
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Setter for tokens
     *
     * @param array $tokens Array of devices's token
     * @return $this
     */
    public function setTokens(array $tokens)
    {
        $this->_checkTokens($tokens);
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * Getter for notification
     *
     * @return array
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Setter for notification
     *
     * @param array $notification Array of keys for the notification
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
     * Getter for datas
     *
     * @return array
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * Setter for datas
     *
     * @param array $datas Array of datas for the push
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
     * Getter for parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Setter for parameters
     *
     * @param array $parameters Array of parameters for the push
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->_checkParameters($parameters);
        $this->parameters = Hash::merge($this->config('parameters'), $parameters);

        return $this;
    }

    /**
     * Getter for payload
     *
     * @return array
     */
    public function getPayload()
    {
        $notification = $this->getNotification();
        if (!empty($notification)) {
            $this->payload['notification'] = $notification;
        }

        $datas = $this->getDatas();
        if (!empty($datas)) {
            $this->payload['datas'] = $datas;
        }

        return $this->payload;
    }

    /**
     * Check tokens's array
     *
     * @param array $tokens Token's array
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
     * Check notification's array
     *
     * @param array $notification Notification's array
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
            if (!in_array($key, $this->_allowedNotificationKeys)) {
                $notAllowedKeys[] = $key;
            }
        }

        if (!empty($notAllowedKeys)) {
            $notAllowedKeys = implode(', ', $notAllowedKeys);
            throw new InvalidNotificationException("The following keys are not allowed: {$notAllowedKeys}");
        }
    }

    /**
     * Check datas's array
     *
     * @param array $datas Datas's array
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
     * Check parameters's array
     *
     * @param array $parameters
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
     * Execute the push
     *
     * @return bool
     */
    private function _executePush()
    {
        $message = $this->_buildMessage();
        $options = $this->_getHttpOptions();

        $http = new Client();
        $this->response = $http->post($this->config('api.url'), $message, $options);

        return ($this->response->code === '200') ? true : false;
    }

    /**
     * Build the message
     *
     * @return string
     */
    private function _buildMessage()
    {
        $tokens = $this->getTokens();
        $message = (count($tokens) > 1) ? ['registration_ids' => $tokens] : ['to' => current($tokens)];

        $payload = $this->getPayload();
        if (!empty($payload)) {
            $message += $payload;
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

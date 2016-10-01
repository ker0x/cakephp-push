<?php
namespace ker0x\Push\Adapter\Fcm;

use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;
use Cake\Http\Client;
use Cake\Utility\Hash;
use ker0x\Push\Adapter\Exception\InvalidAdapterException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidTokenException;
use ker0x\Push\Adapter\Fcm\Message\Options;
use ker0x\Push\Adapter\Fcm\Message\OptionsBuilder;

class Fcm
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
     * Array of data
     *
     * @var array
     */
    protected $data = [];

    /**
     * Array of request options
     *
     * @var array
     */
    protected $options = [];

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
        'options' => [
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
     * @throws \ker0x\Push\Adapter\Exception\InvalidAdapterException
     */
    public function __construct()
    {
        $config = Configure::read('Push.adapters.Fcm');
        $this->config($config);

        if ($this->config('api.key') === null) {
            throw InvalidAdapterException::noApiKey();
        }
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
     * Getter for payload notification
     *
     * @return array
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Setter for payload notification
     *
     * Authorized keys for the notification are:
     *
     * - `title` Indicates notification title.
     * - `body` Indicates notification body text.
     * - `badge` Indicates the badge on the client app home icon. (iOS)
     * - `icon` Indicates notification icon. (Android)
     * - `sound` Indicates a sound to play when the device receives a notification.
     * - `tag` Indicates whether each notification results in a new entry in the
     *   notification drawer on Android. (Android)
     * - `color` Indicates color of the icon, expressed in #rrggbb format. (Android)
     * - `click_action` Indicates the action associated with a user click on the notification.
     * - `body_loc_key` Indicates the key to the body string for localization.
     * - `body_loc_args` Indicates the string value to replace format specifiers in the
     *   body string for localization.
     * - `title_loc_key` Indicates the key to the title string for localization.
     * - `title_loc_args` Indicates the string value to replace format specifiers in
     *   the title string for localization.
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
     * Getter for payload data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Setter for payload data
     *
     * @param array $data Array of data for the push
     * @return $this
     */
    public function setData(array $data)
    {
        $this->_checkData($data);
        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = ($value) ? 'true' : 'false';
            }
            $data[$key] = (string)$value;
        }
        $this->data = $data;

        return $this;
    }

    /**
     * Getter for payload options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Setter for payload options
     *
     * Authorized keys for options's array are:
     *
     * - `collapse_key` This parameter identifies a group of messages.
     * - `priority` Sets the priority of the message.
     * - `content_available` When a notification or message is sent and
     *   this is set to true, an inactive client app is awoken.
     * - `time_to_live` This parameter specifies how long (in seconds)
     *   the message should be kept in FCM storage if the device is offline.
     * - `restricted_package_name` This parameter specifies the package name
     *   of the application where the registration tokens must match in order
     *   to receive the message.
     * - `dry_run` This parameter, when set to true, allows developers to test
     *   a request without actually sending a message.
     *
     * @param array|OptionsBuilder $options Options for the push
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = (new Options($options))->build();

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

        $data = $this->getData();
        if (!empty($data)) {
            $this->payload['data'] = $data;
        }

        return $this->payload;
    }

    /**
     * Check tokens's array
     *
     * @param array $tokens Token's array
     * @return void
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidTokenException
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
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
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
     * Check data's array
     *
     * @param array $data Datas's array
     * @return void
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException
     */
    private function _checkData($data)
    {
        if (empty($data)) {
            throw new InvalidDataException("Array can not be empty.");
        }
    }

    /**
     * Build the message
     *
     * @return string
     */
    protected function _getMessage()
    {
        $tokens = $this->getTokens();
        $message = (count($tokens) > 1) ? ['registration_ids' => $tokens] : ['to' => current($tokens)];

        $payload = $this->getPayload();
        if (!empty($payload)) {
            $message += $payload;
        }

        $options = $this->getOptions();
        if (!empty($options)) {
            $message += $options;
        }

        return json_encode($message);
    }

    /**
     * Return options for the HTTP request
     *
     * @return array $options
     */
    protected function _getHttpOptions()
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

<?php

namespace ker0x\Push\Adapter;

use Cake\Network\Http\Client;
use Cake\Utility\Hash;
use ker0x\Push\AdapterInterface;
use ker0x\Push\Exception;

class FcmAdapter implements AdapterInterface
{

    use InstanceConfigTrait;

    /**
     * Default config
     *
     * @var array
     */
    protected $_defaultConfig = [
        'api' => [
            'key' => null,
            'url' => 'https://fcm.googleapis.com/fcm/send'
        ],
        'parameters' => [
            'collapse_key' => null,
            'priority' => 'normal',
            'delay_while_idle' => false,
            'dry_run' => false,
            'time_to_live' => 0,
            'restricted_package_name' => null
        ],
        'http' => []
    ];

    /**
     * List of parameters available to use in notification messages.
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
        'title_loc_args'
    ];

    /**
     * Error code and message.
     *
     * @var array
     */
    protected $_errorMessages = [];

    /**
     * Response of the request
     *
     * @var object
     */
    protected $_response = null;

    /**
     * Constructor
     *
     * @param array $config Array of configuration settings
     */
    public function __construct(array $config = [])
    {
        $this->config($config);

        $this->_errorMessages = [
            '400' => __('Error 400. The request could not be parsed as JSON.'),
            '401' => __('Error 401. Unable to authenticating the sender account.'),
            '500' => __('Error 500. Internal Server Error.'),
            '503' => __('Error 503. Service Unavailable.')
        ];
    }

    /**
     * @inheritdoc
     */
    public function send($ids = null, array $payload = [], array $parameters = [])
    {
        $ids = $this->_checkIds($ids);

        if (!is_array($payload)) {
            throw new Exception(__('Payload must be an array.'));
        }

        if (isset($payload['notification'])) {
            $payload['notification'] = $this->_checkNotification($payload['notification']);
        }

        if (isset($payload['data'])) {
            $payload['data'] = $this->_checkData($payload['data']);
        }

        $parameters = $this->_checkParameters($parameters);

        $message = $this->_buildMessage($ids, $payload, $parameters);

        return $this->_executePush($message);
    }

    /**
     * @inheritdoc
     */
    public function response()
    {
        if ($this->_response->code !== '200') {
            $errorMessage = __('There was an error while sending the push');
            if (array_key_exists($this->_response->code, $this->_errorMessages)) {
                $errorMessage = $this->_errorMessages[$this->_response->code];
            }
            throw new Exception($errorMessage);
        }

        return json_decode($this->_response->body, true);
    }

    /**
     * Send the message throught a POST request to the GCM servers
     *
     * @param string $message The message to send
     * @throws Exception
     * @return bool
     */
    protected function _executePush($message)
    {
        $options = $this->_getHttpOptions();

        $http = new Client();
        $this->_response = $http->post($this->config('api.url'), $message, $options);

        return ($this->_response->code === '200') ? true : false;
    }

    /**
     * Build the message from the ids, payload and parameters
     *
     * @param array|string $ids Devices'ids
     * @param array $payload The notification and/or some datas
     * @param array $parameters Parameters for the GCM request
     * @return string
     */
    protected function _buildMessage($ids, $payload, $parameters)
    {
        $message = (count($ids) > 1) ? ['registration_ids' => $ids] : ['to' => current($ids)];

        if (!empty($payload)) {
            $message += $payload;
        }

        if (!empty($parameters)) {
            $message += $parameters;
        }

        return json_encode($message);
    }

    /**
     * Check if the ids are correct
     *
     * @param mixed $ids Devices'ids
     * @throws Exception
     * @return array
     */
    protected function _checkIds($ids)
    {
        if (is_string($ids)) {
            $ids = (array)$ids;
        }

        if (is_null($ids) || !is_array($ids) || empty($ids)) {
            throw new Exception(__('Ids must be a string or an array with at least 1 token.'));
        }

        if (is_array($ids) && count($ids) > 1000) {
            throw new Exception(__('Ids must contain at least 1 and at most 1000 registration tokens.'));
        }

        return $ids;
    }

    /**
     * Check if the notification array is correctly build
     *
     * @param array $notification The notification
     * @throws Exception
     * @return array $notification
     */
    protected function _checkNotification(array $notification = [])
    {
        if (!is_array($notification)) {
            throw new Exception('Notification must be an array.');
        }

        if (empty($notification) || !isset($notification['title'])) {
            throw new Exception('Notification\'s array must contain at least a key title.');
        }

        if (!isset($notification['icon'])) {
            $notification['icon'] = 'myicon';
        }

        foreach ($notification as $key => $value) {
            if (!in_array($key, $this->_allowedNotificationParameters)) {
                throw new Exception("The key {$key} is not allowed in notifications.");
            }
        }

        return $notification;
    }

    /**
     * Check if the data array is correctly build
     *
     * @param array $data Some datas
     * @throws Exception
     * @return array $data
     */
    protected function _checkData(array $data = [])
    {
        if (!is_array($data)) {
            throw new Exception('Data must ba an array.');
        }

        if (empty($data)) {
            throw new Exception('Data\'s array can\'t be empty.');
        }

        // Convert all data into string
        foreach ($data as $key => $value) {
            $data[$key] = (string)$value;
        }

        return $data;
    }

    /**
     * Check the parameters for the message
     *
     * @param array $parameters Parameters for the GCM request
     * @throws Exception
     * @return array $parameters
     */
    protected function _checkParameters(array $parameters = [])
    {
        if (!is_array($parameters)) {
            throw new Exception(__('Parameters must be an array.'));
        }

        $parameters = Hash::merge($this->config('parameters'), $parameters);

        if (isset($parameters['time_to_live']) && !is_int($parameters['time_to_live'])) {
            $parameters['time_to_live'] = (int)$parameters['time_to_live'];
        }

        if (isset($parameters['delay_while_idle']) && !is_bool($parameters['delay_while_idle'])) {
            $parameters['delay_while_idle'] = (bool)$parameters['delay_while_idle'];
        }

        if (isset($parameters['dry_run']) && !is_bool($parameters['dry_run'])) {
            $parameters['dry_run'] = (bool)$parameters['dry_run'];
        }

        return $parameters;
    }

    /**
     * Return options for the HTTP request
     *
     * @throws Exception
     * @return array $options
     */
    protected function _getHttpOptions()
    {
        if ($this->config('api.key') === null) {
            throw new Exception(__('No API key set. Push not triggered'));
        }

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

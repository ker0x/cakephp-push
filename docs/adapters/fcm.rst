Firebase Cloud Messaging Adapter
================================

Introduction
------------

It currently only supports HTTP protocol for :

    - sending a downstream message to one or multiple devices


Configuration
-------------

First, you have to get an API key. Go to https://console.firebase.google.com/ , create a project then in your project's settings you will see your Web API Key.

Update your ``push.php`` config file to set Fcm to the adapters's array:

.. code:: php

    return [
        'Push' => [
            'adapters' => [
                'Fcm' => [
                    'api' => [
                        'key' => 'your_web_API_key',
                        'url' => 'https://fcm.googleapis.com/fcm/send',
                    ],
                ],
            ],
        ],
    ];

Usage
-----

.. code:: php

    use ker0x\Push\Adapter\FcmAdapter;

    $adapter = new FcmAdapter();
    $adapter
        ->setTokens($tokens)
        ->setNotification($notification)
        ->setData($data)
        ->setOptions($options);

where:

    - ``$tokens`` is an array of device's token. (required)
    - ``$notification`` is an array containing the notification. (optional)
    - ``data`` is an array with some data that will be passed. (optional)
    - ``$options`` is an array of options for the payload. (optional)

Example
-------

.. code:: php

    use ker0x\Push\Adapter\FcmAdapter;
    use ker0x\Push\Push;

    $adapter = new FcmAdapter();
    $adapter
        ->setTokens(['1', '2', '3', '4'])
        ->setNotification([
            'title' => 'Hello World',
            'body' => 'My awesome Hello World!'
        ])
        ->setData([
            'data-1' => 'Lorem ipsum',
            'data-2' => 1234,
            'data-3' => true
        ])
        ->setOptions([
            'dry_run' => true
        ]);

    $push = new Push($adapter);

    // Make the push
    $result = $push->send();

    // Get the response
    $response = $push->response();

Appendice
---------

`FCM HTTP Protocol reference <https://firebase.google.com/docs/cloud-messaging/http-server-ref>`__
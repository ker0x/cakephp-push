Firebase Cloud Messaging Adapter
================================

Introduction
------------

First, you have to get an API key. Go to https://console.firebase.google.com/ , create a project then in your project's settings you will see your Web API Key.

Configuration
-------------

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
        ->setDatas($datas)
        ->setParameters($parameters);

where:

    - ``$tokens`` is an array of device's token. (required)
    - ``$notification`` is an array containing the notification. (optional)
    - ``datas`` is an array with some datas that will be passed. (optional)
    - ``$paramaters`` is an array of parameters for the notification. (optional)

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
        ->setDatas([
            'data-1' => 'Lorem ipsum',
            'data-2' => 1234,
            'data-3' => true
        ])
        ->setParameters([
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
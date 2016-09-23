Configuration
=============

Make a config file ``config/push.php``:

.. code:: php

    return [
        'Push' => [
            'adapters' => [
                'Fcm' => [
                    'api' => [
                        'key' => '<api-key>',
                        'url' => 'https://fcm.googleapis.com/fcm/send',
                    ],
                ],
            ],
        ],
    ];
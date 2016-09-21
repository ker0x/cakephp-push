<?php
/**
 * Push Plugin example config
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 */

use Cake\Core\Configure;

return [
    'Push' => [
        'adapters' => [
            'Fcm' => [
                'enabled' => true,
                'api' => [
                    'key' => null,
                    'url' => 'https://fcm.googleapis.com/fcm/send',
                ],
            ],
        ],
        'debug_mode' => (bool)Configure::read('debug'),
        'debug_file' => LOGS . 'push.log',
    ]
];
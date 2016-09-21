<?php
/**
 * Push Plugin bootstrap
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 */
use Cake\Core\Configure;

if (file_exists(CONFIG . 'push.php')) {
    Configure::load('push');
} else {
    $config = [
        'adapters' => [
            'Fcm' => [
                'enabled' => true,
                'api' => [
                    'key' => null,
                    'url' => 'https://fcm.googleapis.com/fcm/send',
                ],
            ]
        ],
        'debug_mode' => (bool)Configure::read('debug'),
        'debug_file' => LOGS . 'push.log',
    ];

    Configure::write('Push', $config);
}
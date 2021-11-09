<?php

namespace Kerox\Push\Test\TestCase;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Kerox\Push\Adapter\Fcm;
use Kerox\Push\Push;

class PushTest extends TestCase {

    /**
     * @var array|string|false
     */
    public $api_key;

    /**
     * @var array|string|false
     */
    public $token;

    /**
     * @return void
     */
    public function setUp(): void {
        $this->api_key = getenv('FCM_API_KEY');
        $this->token = getenv('TOKEN');
    }

    /**
     * @return void
     */
    public function testFcmAdapter() {
        Configure::write('Push.adapters.Fcm.api.key', $this->api_key);
        $adapter = new Fcm();
        $adapter
            ->setTokens([$this->token])
            ->setNotification([
                'title' => 'Hello World',
                'body' => 'My awesome Hello World!',
            ])
            ->setDatas([
                'data-1' => 'Lorem ipsum',
                'data-2' => 1234,
                'data-3' => true,
            ])
            ->setParameters([
                'dry_run' => true,
            ]);

        $push = new Push($adapter);

        $result = $push->send();
        $response = $push->response();

        $this->assertTrue($result);
        $this->assertEquals(1, $response->getJson()['success']);
        $this->assertEquals(0, $response->getJson()['failure']);
    }

    /**
     * @return void
     */
    public function tearDown(): void {
        unset($this->api_key, $this->token);
    }

}

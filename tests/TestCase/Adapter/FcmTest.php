<?php

namespace Kerox\Push\Test\TestCase\Adapter;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Exception;
use InvalidArgumentException;
use Kerox\Push\Adapter\Fcm;

class FcmTest extends TestCase {

    /**
     * @var \Kerox\Push\Adapter\Fcm
     */
    public $adapter;

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
        $this->adapter = new Fcm();
        $this->api_key = getenv('FCM_API_KEY');
        $this->token = getenv('TOKEN');
    }

    /**
     * @return void
     */
    public function testEmptyTokens() {
        $this->expectException(InvalidArgumentException::class);
        $this->adapter->setTokens([]);
    }

    /**
     * @return void
     */
    public function testToManyTokens() {
        $tokens = [];
        for ($i = 1; $i <= 1001; $i++) {
            $tokens[] = $i;
        }

        $this->expectException(InvalidArgumentException::class);
        $this->adapter->setTokens($tokens);
    }

    /**
     * @return void
     */
    public function testGetTokens() {
        $this->adapter->setTokens([1, 2, 3]);
        $tokens = $this->adapter->getTokens();

        $this->assertEquals([1, 2, 3], $tokens);
    }

    /**
     * @return void
     */
    public function testEmptyNotification() {
        $this->expectException(InvalidArgumentException::class);
        $this->adapter->setNotification([]);
    }

    /**
     * @return void
     */
    public function testKeysNotification() {
        $exceptionMessage = null;
        $notification = [
            'title' => 'Hello world',
            'foo' => 'bar',
            'bar' => 'foo',
        ];

        try {
            $this->adapter->setNotification($notification);
        } catch (\InvalidArgumentException $e) {
            $exceptionMessage = $e->getMessage();
        }

        $this->assertEquals('The following keys are not allowed: foo, bar', $exceptionMessage);
    }

    /**
     * @return void
     */
    public function testGetNotification() {
        $this->adapter->setNotification(['title' => 'Hello world']);
        $notification = $this->adapter->getNotification();

        $this->assertEquals(['title' => 'Hello world', 'icon' => 'myicon'], $notification);
    }

    /**
     * @return void
     */
    public function testEmptyDatas() {
        $this->expectException(InvalidArgumentException::class);
        $this->adapter->setDatas([]);
    }

    /**
     * @return void
     */
    public function testGetDatas() {
        $this->adapter->setDatas([
            'data-1' => 'Lorem ipsum',
            'data-2' => 1234,
            'data-3' => true,
            'data-4' => false,
        ]);
        $datas = $this->adapter->getDatas();

        $this->assertEquals([
            'data-1' => 'Lorem ipsum',
            'data-2' => '1234',
            'data-3' => 'true',
            'data-4' => 'false',
        ], $datas);
    }

    /**
     * @return void
     */
    public function testEmptyParameters() {
        $this->expectException(InvalidArgumentException::class);
        $this->adapter->setParameters([]);
    }

    /**
     * @return void
     */
    public function testGetParameters() {
        $this->adapter->setParameters([
            'dry_run' => true,
        ]);
        $parameters = $this->adapter->getParameters();

        $this->assertEquals([
            'collapse_key' => null,
            'priority' => 'normal',
            'dry_run' => true,
            'time_to_live' => 0,
            'restricted_package_name' => null,
            'content_available' => false,
            'mutable_content' => false,
        ], $parameters);
    }

    /**
     * @return void
     */
    public function testGetEmptyPayload() {
        $payload = $this->adapter->getPayload();
        $this->assertEquals([], $payload);
    }

    /**
     * @return void
     */
    public function testGetFilledPayload() {
        $this->adapter
            ->setNotification(['title' => 'Hello world'])
            ->setDatas([
                'data-1' => 'Lorem ipsum',
                'data-2' => 1234,
                'data-3' => true,
                'data-4' => false,
            ]);

        $payload = $this->adapter->getPayload();
        $this->assertEquals([
            'notification' => [
                'title' => 'Hello world',
                'icon' => 'myicon',
            ],
            'data' => [
                'data-1' => 'Lorem ipsum',
                'data-2' => '1234',
                'data-3' => 'true',
                'data-4' => 'false',
            ],
        ], $payload);
    }

    /**
     * @return void
     */
    public function testSendAndResponse() {
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

        $result = $adapter->send();
        $response = $adapter->response();

        $this->assertTrue($result);
        $this->assertEquals(1, $response->getJson()['success']);
        $this->assertEquals(0, $response->getJson()['failure']);
    }

    /**
     * @return void
     */
    public function testNoApiKeyAdapter() {
        Configure::write('Push.adapters.Fcm.api.key', null);
        $this->expectException(Exception::class);
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
            ])
            ->send();
    }

    /**
     * @return void
     */
    public function tearDown(): void {
        unset($this->adapter, $this->api_key, $this->token);
    }

}

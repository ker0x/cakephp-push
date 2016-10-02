<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;
use ker0x\Push\Adapter\FcmAdapter;

class FcmAdapterTest extends IntegrationTestCase
{

    public $adapter;
    public $api_key;
    public $token;

    public function setUp()
    {
        Configure::restore('Push.adapters.Fcm.api.key', 'default');
        $this->adapter = new FcmAdapter();
        $this->adapter
            ->setTokens(['1', '2', '3', '4'])
            ->setNotification([
                'title' => 'Hello World',
                'body' => 'My awesome Hello World'
            ])
            ->setData([
                'data-1' => 'data-1',
                'data-2' => true
            ])
            ->setOptions([
                'dry_run' => true
            ]);
    }

    public function testGetApiUrl()
    {
        $this->assertEquals('https://fcm.googleapis.com/fcm/send', $this->adapter->getApiUrl());
    }

    public function testGetHttpData()
    {
        $this->assertEquals('{"registration_ids":["1","2","3","4"],"notification":{"title":"Hello World","body":"My awesome Hello World"},"data":{"data-1":"data-1","data-2":"true"},"dry_run":true}', $this->adapter->getHttpData());
    }

    public function testGetHttpOptions()
    {
        $this->assertEquals([
            'type' => 'json',
            'headers' => [
                'Authorization' => 'key=1234567890',
                'Content-Type' => 'application/json',
            ],
        ], $this->adapter->getHttpOptions());
    }

    public function tearDown()
    {
        unset($this->adapter, $this->api_key, $this->token);
    }
}

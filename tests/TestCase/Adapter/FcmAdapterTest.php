<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;
use ker0x\Push\Adapter\InvalidAdapterException;
use ker0x\Push\Adapter\FcmAdapter;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidTokenException;

class FcmAdapterTest extends IntegrationTestCase
{

    public $adapter;
    public $api_key;
    public $token;

    public function setUp()
    {
        Configure::restore('Push.adapters.Fcm.api.key', 'default');
        $this->adapter = new FcmAdapter();
        $this->api_key = getenv('FCM_API_KEY');
        $this->token = getenv('TOKEN');
    }

    public function testGetApiUrl()
    {
        $this->assertEquals('https://fcm.googleapis.com/fcm/send', $this->adapter->getApiUrl());
    }

    public function tearDown()
    {
        unset($this->adapter, $this->api_key, $this->token);
    }
}

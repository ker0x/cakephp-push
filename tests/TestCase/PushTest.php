<?php
namespace ker0x\Push\Test\TestCase;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;
use ker0x\Push\Adapter\FcmAdapter;
use ker0x\Push\Push;

class PushTest extends IntegrationTestCase
{

    public $api_key;
    public $token;

    public function setUp()
    {
        $this->api_key = getenv('FCM_API_KEY');
        $this->token = getenv('TOKEN');
    }

    public function testFcmAdapter()
    {
        Configure::write('Push.adapters.Fcm.api.key', $this->api_key);
        $adapter = new FcmAdapter();
        $adapter
            ->setTokens([$this->token])
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

        $result = $push->send();
        $response = $push->response();

        $this->assertTrue($result);
        $this->assertEquals(1, $response->json['success']);
        $this->assertEquals(0, $response->json['failure']);
    }

    public function tearDown()
    {
        unset($this->api_key, $this->token);
    }
}

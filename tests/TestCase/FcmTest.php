<?php
namespace ker0x\Push\Test\TestCase;

use Cake\TestSuite\IntegrationTestCase;
use ker0x\Push\Adapter\FcmAdapter;
use ker0x\Push\Push;

class FcmTest extends IntegrationTestCase
{
    public $push;

    public $tokens;

    public function setUp()
    {
        $adapter = new FcmAdapter([
            'api' => [
                'key' => getenv('FCM_API_KEY')
            ],
            'http' => [
                'ssl_verify_peer' => false,
                'ssl_verify_peer_name' => false,
                'ssl_verify_host' => false
            ]
        ]);

        $this->push = new Push($adapter);
        $this->tokens = getenv('TOKEN');
    }

    public function testPush()
    {
        $result = $this->push->send(
            $this->tokens,
            [
                'notification' => [
                    'title' => 'Hello World',
                    'body' => 'My awesome Hello World!'
                ],
                'data' => [
                    'data-1' => 'Lorem ipsum',
                    'data-2' => 1234,
                    'data-3' => true
                ]
            ],
            [
                'dry_run' => true
            ]
        );
        $response = $this->push->response();

        $this->assertTrue($result);
        $this->assertEquals(1, $response['success']);
        $this->assertEquals(0, $response['failure']);
    }

    public function tearDown()
    {
        unset($this->push, $this->tokens);
    }
}

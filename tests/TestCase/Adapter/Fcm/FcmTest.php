<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestCase;
use ker0x\Push\Adapter\Fcm\Fcm;
use ker0x\Push\Adapter\Fcm\Message\DataBuilder;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidDataException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidTokenException;
use ker0x\Push\Adapter\Fcm\Message\NotificationBuilder;
use ker0x\Push\Adapter\Fcm\Message\OptionsBuilder;
use ker0x\Push\Adapter\InvalidAdapterException;

class FcmTest extends IntegrationTestCase
{
    public $fcm;

    public function setUp()
    {
        $this->fcm = new Fcm();
    }

    public function testFcmWithBuilder()
    {
        $notificationBuilder = new NotificationBuilder('title');
        $notificationBuilder
            ->setTitleLocArgs('title_loc_args')
            ->setTitleLocKey('title_loc_key')
            ->setBodyLocArgs('body_loc_args')
            ->setBodyLocKey('body_loc_key')
            ->setClickAction('click_action')
            ->setColor('#FFFFFF')
            ->setTag('tag')
            ->setIcon('icon')
            ->setBadge('badge')
            ->setSound('sound')
            ->setBody('body');

        $dataBuilder = new DataBuilder();
        $dataBuilder
            ->addData('data-1', 'data-1')
            ->addData('data-2', true)
            ->addData('data-3', 1234);

        $optionsBuilder = new OptionsBuilder();
        $optionsBuilder
            ->setRestrictedPackageName('foo')
            ->setCollapseKey('Update available')
            ->setPriority('normal')
            ->setTimeToLive(3600)
            ->setContentAvailable(true)
            ->setDryRun(true);

        $this->fcm
            ->setTokens(['1', '2', '3'])
            ->setNotification($notificationBuilder)
            ->setData($dataBuilder)
            ->setOptions($optionsBuilder);

        $tokens = $this->fcm->getTokens();
        $notification = $this->fcm->getNotification();
        $data = $this->fcm->getData();
        $options = $this->fcm->getOptions();

        $this->assertEquals(['1', '2', '3'], $tokens);
        $this->assertEquals([
            'title' => 'title',
            'body' => 'body',
            'sound' => 'sound',
            'badge' => 'badge',
            'icon' => 'icon',
            'tag' => 'tag',
            'color' => '#FFFFFF',
            'click_action' => 'click_action',
            'body_loc_key' => 'body_loc_key',
            'body_loc_args' => 'body_loc_args',
            'title_loc_key' => 'title_loc_key',
            'title_loc_args' => 'title_loc_args',
        ], $notification);
        $this->assertEquals([
            'data-1' => 'data-1',
            'data-2' => 'true',
            'data-3' => '1234',
        ], $data);
        $this->assertEquals([
            'collapse_key' => 'Update available',
            'content_available' => true,
            'dry_run' => true,
            'priority' => 'normal',
            'restricted_package_name' => 'foo',
            'time_to_live' => 3600,
        ], $options);
    }

    public function testFcmWithArray()
    {
        $this->fcm
            ->setTokens(['1', '2', '3'])
            ->setNotification([
                'title_loc_args' => 'title_loc_args',
                'title_loc_key' => 'title_loc_key',
                'body_loc_args' => 'body_loc_args',
                'body_loc_key' => 'body_loc_key',
                'click_action' => 'click_action',
                'color' => '#FFFFFF',
                'tag' => 'tag',
                'icon' => 'icon',
                'badge' => 'badge',
                'sound' => 'sound',
                'body' => 'body',
                'title' => 'title',
            ])
            ->setData([
                'data-1' => 'data-1',
                'data-2' => true,
                'data-3' => 1234,
            ])
            ->setOptions([
                'time_to_live' => 3600,
                'restricted_package_name' => 'foo',
                'priority' => 'normal',
                'dry_run' => true,
                'content_available' => true,
                'collapse_key' => 'Update available',
            ]);

        $tokens = $this->fcm->getTokens();
        $notification = $this->fcm->getNotification();
        $data = $this->fcm->getData();
        $options = $this->fcm->getOptions();

        $this->assertEquals(['1', '2', '3'], $tokens);
        $this->assertEquals([
            'title' => 'title',
            'body' => 'body',
            'sound' => 'sound',
            'badge' => 'badge',
            'icon' => 'icon',
            'tag' => 'tag',
            'color' => '#FFFFFF',
            'click_action' => 'click_action',
            'body_loc_key' => 'body_loc_key',
            'body_loc_args' => 'body_loc_args',
            'title_loc_key' => 'title_loc_key',
            'title_loc_args' => 'title_loc_args',
        ], $notification);
        $this->assertEquals([
            'data-1' => 'data-1',
            'data-2' => 'true',
            'data-3' => '1234',
        ], $data);
        $this->assertEquals([
            'collapse_key' => 'Update available',
            'content_available' => true,
            'dry_run' => true,
            'priority' => 'normal',
            'restricted_package_name' => 'foo',
            'time_to_live' => 3600,
        ], $options);
    }

    public function testEmptyTokens()
    {
        $this->expectException(InvalidTokenException::class);
        $this->fcm->setTokens([]);
    }

    public function testToManyTokens()
    {
        $tokens = [];
        for ($i = 1; $i <= 1001; $i++) {
            $tokens[] = $i;
        }

        $this->expectException(InvalidTokenException::class);
        $this->fcm->setTokens($tokens);
    }

    public function testEmptyNotification()
    {
        $this->expectException(InvalidNotificationException::class);
        $this->fcm->setNotification([]);
    }

    public function testEmptyData()
    {
        $this->expectException(InvalidDataException::class);
        $this->fcm->setData([]);
    }

    public function testEmptyOptions()
    {
        $this->expectException(InvalidOptionsException::class);
        $this->fcm->setOptions([]);
    }

    public function testGetEmptyPayload()
    {
        $payload = $this->fcm->getPayload();
        $this->assertEquals([], $payload);
    }

    public function testGetFilledPayload()
    {
        $this->fcm
            ->setNotification(['title' => 'Hello world'])
            ->setData([
                'data-1' => 'Lorem ipsum',
                'data-2' => 1234,
                'data-3' => true,
                'data-4' => false,
            ]);

        $payload = $this->fcm->getPayload();
        $this->assertEquals([
            'notification' => [
                'title' => 'Hello world',
            ],
            'data' => [
                'data-1' => 'Lorem ipsum',
                'data-2' => '1234',
                'data-3' => 'true',
                'data-4' => 'false',
            ]
        ], $payload);
    }

    public function testNoApiKey()
    {
        Configure::store('Push.adapters.Fcm.api.key', 'default');
        Configure::write('Push.adapters.Fcm.api.key', null);
        $this->expectException(InvalidAdapterException::class);
        $fcm = new Fcm();
        $fcm
            ->setTokens(['1', '2', '3'])
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
    }
}

<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\TestSuite\TestCase;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException;
use ker0x\Push\Adapter\Fcm\Message\Notification;
use ker0x\Push\Adapter\Fcm\Message\NotificationBuilder;

class NotificationTest extends TestCase
{
    public function testNotificationFromNotificationBuilder()
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

        $notification = new Notification($notificationBuilder);
        $notification = $notification->build();

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
    }

    public function testNotificationFromArray()
    {
        $notification = new Notification([
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
        ]);
        $notification = $notification->build();

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
    }

    public function testNotificationFromEmptyArray()
    {
        $this->expectException(InvalidNotificationException::class);
        new Notification([]);
    }

    public function testNotificationFromArrayWithoutTitle()
    {
        $this->expectException(InvalidNotificationException::class);
        new Notification(['body' => 'body']);
    }
}

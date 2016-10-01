<?php
namespace ker0x\Push\Adapter\Fcm\Message;

use Cake\Utility\Inflector;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException;

/**
 * Class Notification
 * @package ker0x\Push\Adapter\Fcm\Message
 */
class Notification
{

    /**
     * @var null|string
     */
    protected $title;

    /**
     * @var null|string
     */
    protected $body;

    /**
     * @var null|string
     */
    protected $sound;

    /**
     * @var null|string
     */
    protected $badge;

    /**
     * @var null|string
     */
    protected $icon;

    /**
     * @var null|string
     */
    protected $tag;

    /**
     * @var null|string
     */
    protected $color;

    /**
     * @var null|string
     */
    protected $clickAction;

    /**
     * @var null|string
     */
    protected $bodyLocalizationKey;

    /**
     * @var null|string
     */
    protected $bodyLocalizationArgs;

    /**
     * @var null|string
     */
    protected $titleLocalizationKey;

    /**
     * @var null|string
     */
    protected $titleLocalizationArgs;

    /**
     * Notification constructor.
     * @param array|NotificationBuilder $notificationBuilder
     */
    public function __construct($notificationBuilder)
    {
        if (is_array($notificationBuilder)) {
            $notificationBuilder = $this->fromArray($notificationBuilder);
        }

        $this->title = $notificationBuilder->getTitle();
        $this->body = $notificationBuilder->getBody();
        $this->sound = $notificationBuilder->getSound();
        $this->badge = $notificationBuilder->getBadge();
        $this->icon = $notificationBuilder->getIcon();
        $this->tag = $notificationBuilder->getTag();
        $this->color = $notificationBuilder->getColor();
        $this->clickAction = $notificationBuilder->getClickAction();
        $this->bodyLocalizationKey = $notificationBuilder->getBodyLocalizationKey();
        $this->bodyLocalizationArgs = $notificationBuilder->getBodyLocalizationArgs();
        $this->titleLocalizationKey = $notificationBuilder->getTitleLocalizationKey();
        $this->titleLocalizationArgs = $notificationBuilder->getTitleLocalizationArgs();
    }

    /**
     * @return array
     */
    public function build()
    {
        $notification = [
            'title' => $this->title,
            'body' => $this->body,
            'sound' => $this->sound,
            'badge' => $this->badge,
            'icon' => $this->icon,
            'tag' => $this->tag,
            'color' => $this->color,
            'click_action' => $this->clickAction,
            'body_loc_key' => $this->bodyLocalizationKey,
            'body_loc_args' => $this->bodyLocalizationArgs,
            'title_loc_key' => $this->titleLocalizationKey,
            'title_loc_args' => $this->titleLocalizationArgs,
        ];

        return array_filter($notification);
    }

    /**
     * @param array $notificationArray
     * @return \ker0x\Push\Adapter\Fcm\Message\NotificationBuilder
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    private function fromArray(array $notificationArray): NotificationBuilder
    {
        if (empty($notificationArray)) {
            throw InvalidNotificationException::arrayEmpty();
        }

        $notificationBuilder = new NotificationBuilder($notificationArray['title']);
        unset($notificationArray['title']);
        foreach ($notificationArray as $key => $value) {
            $key = Inflector::camelize($key);
            $setter = 'set' . $key;
            $notificationBuilder->$setter($value);
        }

        return $notificationBuilder;
    }
}
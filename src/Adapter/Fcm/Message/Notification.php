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
     * Indicates notification title.
     *
     * @var null|string
     */
    protected $title;

    /**
     * Indicates notification body text.
     *
     * @var null|string
     */
    protected $body;

    /**
     * Indicates a sound to play when the device receives a notification.
     *
     * @var null|string
     */
    protected $sound;

    /**
     * Indicates the badge on the client app home icon. (iOS)
     *
     * @var null|string
     */
    protected $badge;

    /**
     * Indicates notification icon. (Android)
     *
     * @var null|string
     */
    protected $icon;

    /**
     * Indicates whether each notification results in a new entry in the
     * notification drawer on Android. (Android)
     *
     * @var null|string
     */
    protected $tag;

    /**
     * Indicates color of the icon, expressed in #rrggbb format. (Android)
     *
     * @var null|string
     */
    protected $color;

    /**
     * Indicates the action associated with a user click on the notification.
     *
     * @var null|string
     */
    protected $clickAction;

    /**
     * Indicates the key to the body string for localization.
     *
     * @var null|string
     */
    protected $bodyLocKey;

    /**
     * Indicates the string value to replace format specifiers in the
     * body string for localization.
     *
     * @var null|string
     */
    protected $bodyLocArgs;

    /**
     * Indicates the key to the title string for localization.
     *
     * @var null|string
     */
    protected $titleLocKey;

    /**
     * Indicates the string value to replace format specifiers in
     * the title string for localization.
     *
     * @var null|string
     */
    protected $titleLocArgs;

    /**
     * Notification constructor.
     *
     * @param array|\ker0x\Push\Adapter\Fcm\Message\NotificationBuilder $notificationBuilder The notification we want to send
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
        $this->bodyLocKey = $notificationBuilder->getBodyLocKey();
        $this->bodyLocArgs = $notificationBuilder->getBodyLocArgs();
        $this->titleLocKey = $notificationBuilder->getTitleLocKey();
        $this->titleLocArgs = $notificationBuilder->getTitleLocArgs();
    }

    /**
     * Return notification as an array.
     *
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
            'body_loc_key' => $this->bodyLocKey,
            'body_loc_args' => $this->bodyLocArgs,
            'title_loc_key' => $this->titleLocKey,
            'title_loc_args' => $this->titleLocArgs,
        ];

        return array_filter($notification);
    }

    /**
     * Build notification from an array
     *
     * @param array $notificationArray Array of keys for the notification.
     * @return \ker0x\Push\Adapter\Fcm\Message\NotificationBuilder
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    private function fromArray(array $notificationArray)
    {
        if (empty($notificationArray)) {
            throw InvalidNotificationException::arrayEmpty();
        }

        if (!isset($notificationArray['title'])) {
            throw InvalidNotificationException::invalidArray();
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

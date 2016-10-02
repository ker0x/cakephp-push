<?php
namespace ker0x\Push\Adapter\Fcm\Message;

use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException;

/**
 * Class NotificationBuilder
 * @package ker0x\Push\Adapter\Fcm\Message
 */
class NotificationBuilder
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
     * NotificationBuilder constructor.
     *
     * @param string $title
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return null|string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setBody($body)
    {
        $this->isString($body, 'body');
        $this->body = $body;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * @param string $sound
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setSound($sound)
    {
        $this->isString($sound, 'sound');
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param string $badge
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setBadge($badge)
    {
        $this->isString($badge, 'badge');
        $this->badge = $badge;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setIcon($icon)
    {
        $this->isString($icon, 'icon');
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setTag($tag)
    {
        $this->isString($tag, 'tag');
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setColor($color)
    {
        if (!preg_match('/^#[A-Fa-f0-9]{6}$/', $color)) {
            throw InvalidNotificationException::invalidColor();
        }
        $this->color = $color;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getClickAction()
    {
        return $this->clickAction;
    }

    /**
     * @param string $clickAction
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setClickAction($clickAction)
    {
        $this->isString($clickAction, 'click_action');
        $this->clickAction = $clickAction;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBodyLocKey()
    {
        return $this->bodyLocKey;
    }

    /**
     * @param string $bodyLocKey
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setBodyLocKey($bodyLocKey)
    {
        $this->isString($bodyLocKey, 'body_loc_key');
        $this->bodyLocKey = $bodyLocKey;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBodyLocArgs()
    {
        return $this->bodyLocArgs;
    }

    /**
     * @param string $bodyLocArgs
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setBodyLocArgs($bodyLocArgs)
    {
        $this->isString($bodyLocArgs, 'body_loc_args');
        $this->bodyLocArgs = $bodyLocArgs;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitleLocKey()
    {
        return $this->titleLocKey;
    }

    /**
     * @param string $titleLocKey
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setTitleLocKey($titleLocKey)
    {
        $this->isString($titleLocKey, 'title_loc_key');
        $this->titleLocKey = $titleLocKey;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitleLocArgs()
    {
        return $this->titleLocArgs;
    }

    /**
     * @param string $titleLocArgs
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    public function setTitleLocArgs($titleLocArgs)
    {
        $this->isString($titleLocArgs, 'title_loc_args');
        $this->titleLocArgs = $titleLocArgs;

        return $this;
    }

    /**
     * Test if $value is a string.
     *
     * @param string $value The value to test.
     * @param string $key The key of the value.
     * @return void
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidNotificationException
     */
    private function isString($value, $key)
    {
        if (!is_string($value)) {
            throw InvalidNotificationException::mustBeString($key);
        }
    }
}
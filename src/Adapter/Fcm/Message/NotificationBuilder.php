<?php
namespace ker0x\Push\Adapter\Fcm\Message;


/**
 * Class NotificationBuilder
 * @package ker0x\Push\Adapter\Fcm\Message
 */
class NotificationBuilder
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
     * NotificationBuilder constructor.
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
     * @param null|string $body
     * @return $this
     */
    public function setBody($body)
    {
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
     * @param null|string $sound
     * @return $this
     */
    public function setSound($sound)
    {
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
     * @param null|string $badge
     * @return $this
     */
    public function setBadge($badge)
    {
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
     * @param null|string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
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
     * @param null|string $tag
     * @return $this
     */
    public function setTag($tag)
    {
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
     * @param null|string $color
     * @return $this
     */
    public function setColor($color)
    {
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
     * @param null|string $clickAction
     * @return $this
     */
    public function setClickAction($clickAction)
    {
        $this->clickAction = $clickAction;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBodyLocalizationKey()
    {
        return $this->bodyLocalizationKey;
    }

    /**
     * @param null|string $bodyLocalizationKey
     * @return $this
     */
    public function setBodyLocalizationKey($bodyLocalizationKey)
    {
        $this->bodyLocalizationKey = $bodyLocalizationKey;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBodyLocalizationArgs()
    {
        return $this->bodyLocalizationArgs;
    }

    /**
     * @param null|string $bodyLocalizationArgs
     * @return $this
     */
    public function setBodyLocalizationArgs($bodyLocalizationArgs)
    {
        $this->bodyLocalizationArgs = $bodyLocalizationArgs;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitleLocalizationKey()
    {
        return $this->titleLocalizationKey;
    }

    /**
     * @param null|string $titleLocalizationKey
     * @return $this
     */
    public function setTitleLocalizationKey($titleLocalizationKey)
    {
        $this->titleLocalizationKey = $titleLocalizationKey;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitleLocalizationArgs()
    {
        return $this->titleLocalizationArgs;
    }

    /**
     * @param null|string $titleLocalizationArgs
     * @return $this
     */
    public function setTitleLocalizationArgs($titleLocalizationArgs)
    {
        $this->titleLocalizationArgs = $titleLocalizationArgs;

        return $this;
    }
}
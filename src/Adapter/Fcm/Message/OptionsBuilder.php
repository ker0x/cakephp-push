<?php
namespace ker0x\Push\Adapter\Fcm\Message;

use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException;

/**
 * Class OptionsBuilder
 * @package ker0x\Push\Adapter\Fcm\Message
 */
class OptionsBuilder
{
    
    /**
     *
     */
    const NORMAL = 'normal';

    /**
     *
     */
    const HIGH = 'high';

    /**
     * This parameter identifies a group of messages.
     *
     * @var null|string
     */
    protected $collapseKey;

    /**
     * Sets the priority of the message.
     *
     * @var null|string
     */
    protected $priority;

    /**
     * When a notification or message is sent and this is set to true,
     * an inactive client app is awoken.
     *
     * @var bool
     */
    protected $contentAvailable = false;

    /**
     * This parameter specifies how long (in seconds) the message should be kept
     * in FCM storage if the device is offline.
     *
     * @var null|int
     */
    protected $timeToLive;

    /**
     * This parameter specifies the package name of the application where the registration
     * tokens must match in order to receive the message.
     *
     * @var null|string
     */
    protected $restrictedPackageName;

    /**
     * This parameter, when set to true, allows developers to test a request without
     * actually sending a message.
     *
     * @var bool
     */
    protected $dryRun = false;

    /**
     * Getter for collapseKey.
     *
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
     * Setter for collapseKey.
     *
     * @param string $collapseKey
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    public function setCollapseKey($collapseKey)
    {
        if (!is_string($collapseKey)) {
            throw InvalidOptionsException::mustBeString('collapse_key');
        }
        $this->collapseKey = $collapseKey;

        return $this;
    }

    /**
     * Getter for priority.
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Setter for priority.
     *
     * @param string $priority
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    public function setPriority($priority)
    {
        if (!in_array($priority, [self::NORMAL, self::HIGH])) {
            throw InvalidOptionsException::invalidPriority();
        }
        $this->priority = $priority;

        return $this;
    }

    /**
     * Getter for contentAvailable.
     *
     * @return boolean
     */
    public function isContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
     * Setter for contentAvailable.
     *
     * @param boolean $contentAvailable
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    public function setContentAvailable($contentAvailable)
    {
        if (!is_bool($contentAvailable)) {
            throw InvalidOptionsException::mustBeBool('content_available');
        }
        $this->contentAvailable = $contentAvailable;

        return $this;
    }

    /**
     * Getter for timeToLive.
     *
     * @return string
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * Setter for timeToLive.
     *
     * @param int $timeToLive
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    public function setTimeToLive($timeToLive)
    {
        if (!is_int($timeToLive) || $timeToLive < 0 || $timeToLive > 2419200) {
            throw InvalidOptionsException::invalidTimeToLive($timeToLive);
        }
        $this->timeToLive = $timeToLive;

        return $this;
    }

    /**
     * Getter for restrictedPackageName.
     *
     * @return string
     */
    public function getRestrictedPackageName()
    {
        return $this->restrictedPackageName;
    }

    /**
     * Setter for restrictedPackageName.
     *
     * @param string $restrictedPackageName
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    public function setRestrictedPackageName($restrictedPackageName)
    {
        if (!is_string($restrictedPackageName)) {
            throw InvalidOptionsException::mustBeString('restricted_package_name');
        }
        $this->restrictedPackageName = $restrictedPackageName;

        return $this;
    }

    /**
     * Getter for dryRun.
     *
     * @return boolean
     */
    public function isDryRun()
    {
        return $this->dryRun;
    }

    /**
     * Setter for dryRun.
     *
     * @param boolean $dryRun
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    public function setDryRun($dryRun)
    {
        if (!is_bool($dryRun)) {
            throw InvalidOptionsException::mustBeBool('dry_run');
        }
        $this->dryRun = $dryRun;

        return $this;
    }
}

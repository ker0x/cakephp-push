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
     * @var null|string
     */
    protected $collapseKey;

    /**
     * @var null|string
     */
    protected $priority;

    /**
     * @var bool
     */
    protected $contentAvailable = false;

    /**
     * @var null|int
     */
    protected $timeToLive;

    /**
     * @var null|string
     */
    protected $restrictedPackageName;

    /**
     * @var bool
     */
    protected $dryRun = false;

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapseKey;
    }

    /**
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
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isContentAvailable()
    {
        return $this->contentAvailable;
    }

    /**
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
     * @return string
     */
    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    /**
     * @param int $timeToLive
     * @return $this
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    public function setTimeToLive($timeToLive)
    {
        if (!is_int($timeToLive) || $timeToLive < 0 || $timeToLive > 2419200) {
            throw InvalidOptionsException::invalidTTL($timeToLive);
        }
        $this->timeToLive = $timeToLive;

        return $this;
    }

    /**
     * @return string
     */
    public function getRestrictedPackageName()
    {
        return $this->restrictedPackageName;
    }

    /**
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
     * @return boolean
     */
    public function isDryRun()
    {
        return $this->dryRun;
    }

    /**
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

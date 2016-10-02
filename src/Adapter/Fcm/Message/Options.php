<?php
namespace ker0x\Push\Adapter\Fcm\Message;


use Cake\Utility\Inflector;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException;

class Options
{

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
     * Options constructor.
     *
     * @param array|OptionsBuilder $optionsBuilder
     */
    public function __construct($optionsBuilder)
    {
        if (is_array($optionsBuilder)) {
            $optionsBuilder = $this->fromArray($optionsBuilder);
        }

        $this->collapseKey = $optionsBuilder->getCollapseKey();
        $this->priority = $optionsBuilder->getPriority();
        $this->contentAvailable = $optionsBuilder->isContentAvailable() ? true : null;
        $this->timeToLive = $optionsBuilder->getTimeToLive();
        $this->dryRun = $optionsBuilder->isDryRun() ? true : null;
        $this->restrictedPackageName = $optionsBuilder->getRestrictedPackageName();
    }

    /**
     * Return the options as an array.
     *
     * @return array
     */
    public function build()
    {
        $options = [
            'collapse_key' => $this->collapseKey,
            'content_available' => $this->contentAvailable,
            'dry_run' => $this->dryRun,
            'priority' => $this->priority,
            'restricted_package_name' => $this->restrictedPackageName,
            'time_to_live' => $this->timeToLive,
        ];

        return array_filter($options);
    }

    /**
     * Build options from an array.
     *
     * @param array $optionsArray
     * @return \ker0x\Push\Adapter\Fcm\Message\OptionsBuilder
     * @throws \ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException
     */
    private function fromArray(array $optionsArray)
    {
        if (empty($optionsArray)) {
            throw InvalidOptionsException::arrayEmpty();
        }

        $optionsBuilder = new OptionsBuilder();
        foreach ($optionsArray as $key => $value) {
            $key = Inflector::camelize($key);
            $setter = 'set' . $key;
            $optionsBuilder->$setter($value);
        }

        return $optionsBuilder;
    }
}
<?php
namespace ker0x\Push\Test\TestCase\Fcm;

use Cake\TestSuite\TestCase;
use ker0x\Push\Adapter\Fcm\Message\Exception\InvalidOptionsException;
use ker0x\Push\Adapter\Fcm\Message\Options;
use ker0x\Push\Adapter\Fcm\Message\OptionsBuilder;

class OptionsTest extends TestCase
{
    public function testOptionsFromOptionsBuilder()
    {
        $optionsBuilder = new OptionsBuilder();
        $optionsBuilder
            ->setRestrictedPackageName('foo')
            ->setCollapseKey('Update available')
            ->setPriority('normal')
            ->setTimeToLive(3600)
            ->setContentAvailable(true)
            ->setDryRun(true);

        $options = new Options($optionsBuilder);
        $options = $options->build();

        $this->assertEquals([
            'collapse_key' => 'Update available',
            'content_available' => true,
            'dry_run' => true,
            'priority' => 'normal',
            'restricted_package_name' => 'foo',
            'time_to_live' => 3600,
        ], $options);
    }

    public function testOptionsFromArray()
    {
        $options = new Options([
            'time_to_live' => 3600,
            'restricted_package_name' => 'foo',
            'priority' => 'normal',
            'dry_run' => true,
            'content_available' => true,
            'collapse_key' => 'Update available',
        ]);
        $options = $options->build();

        $this->assertEquals([
            'collapse_key' => 'Update available',
            'content_available' => true,
            'dry_run' => true,
            'priority' => 'normal',
            'restricted_package_name' => 'foo',
            'time_to_live' => 3600,
        ], $options);
    }

    public function testOptionsFromEmptyArray()
    {
        $this->expectException(InvalidOptionsException::class);
        new Options([]);
    }
}
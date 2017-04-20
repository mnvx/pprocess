<?php

namespace Mnvx\PProcess;

use Mnvx\PProcess\Command\Command;
use Mnvx\PProcess\Command\CommandSet;
use Mnvx\PProcess\Constraint\AsyncCommand;
use Mnvx\PProcess\Constraint\AsyncCommands;

trait AsyncTrait
{
    /**
     * Assert that command can be executed in async mode
     * @param Command $command
     * @param string $message
     */
    public static function assertAsyncCommand($command, $message = '')
    {
        static::assertThat($command, new AsyncCommand(), $message);
    }

    /**
     * Assert that command can't be executed in async mode
     * @param Command $command
     * @param string $message
     */
    public static function assertNotAsyncCommand($command, $message = '')
    {
        static::assertThat($command, static::logicalNot(new AsyncCommand()), $message);
    }

    /**
     * Assert that commands can be executed in async mode
     * @param CommandSet $commandSet
     * @param string $message
     */
    public static function assertAsyncCommands($commandSet, $message = '')
    {
        static::assertThat($commandSet, new AsyncCommands(), $message);
    }

    /**
     * Assert that commands can't be executed in async mode
     * @param CommandSet $commandSet
     * @param string $message
     */
    public static function assertNotAsyncCommands($commandSet, $message = '')
    {
        static::assertThat($commandSet, static::logicalNot(new AsyncCommands()), $message);
    }
}
<?php

use PHPUnit\Framework\TestCase;
use Mnvx\PProcess\Command\Command;
use Mnvx\PProcess\AsyncTrait;
use Mnvx\PProcess\Command\CommandSet;

class AsyncTraitTest extends TestCase
{
    use AsyncTrait;

    public function testAsyncCommand()
    {
        $this->assertAsyncCommand(new Command('echo 1'));
        $this->assertAsyncCommand(new Command('echo 1', dirname(__FILE__)));
        $this->assertAsyncCommand(new Command('echo 1', dirname(__FILE__), 1));
        $this->assertAsyncCommand(new Command('echo 1', dirname(__FILE__), 2));
        $this->assertAsyncCommand(new Command('echo 1', dirname(__FILE__), 20));
    }

    public function testNotAsyncCommand()
    {
        $this->assertNotAsyncCommand(new Command('exit 1'));
        $this->assertNotAsyncCommand(new Command('exit 1', dirname(__FILE__)));
        $this->assertNotAsyncCommand(new Command('exit 1', dirname(__FILE__), 1));
        $this->assertNotAsyncCommand(new Command('exit 1', dirname(__FILE__), 2));
        $this->assertNotAsyncCommand(new Command('exit 1', dirname(__FILE__), 20));
    }

    public function testAsyncCommands()
    {
        $this->assertAsyncCommands(new CommandSet(['echo 1', 'echo 2']));
        $this->assertAsyncCommands(new CommandSet(['echo 1'], dirname(__FILE__)));
        $this->assertAsyncCommands(new CommandSet(['echo 1'], dirname(__FILE__), 1));
        $this->assertAsyncCommands(new CommandSet(['echo 1'], dirname(__FILE__), 2));
        $this->assertAsyncCommands(new CommandSet(['echo 1'], dirname(__FILE__), 20));
        $this->assertAsyncCommands(new CommandSet(['commands/echo', 'echo 1'], dirname(__FILE__)));
        $this->assertAsyncCommands(new CommandSet(['commands/flock', 'commands/echo', 'echo 1'], dirname(__FILE__), 1));
    }

    public function testNotAsyncCommands()
    {
        $this->assertNotAsyncCommands(new CommandSet(['exit 1', 'exit 2']));
        $this->assertNotAsyncCommands(new CommandSet(['exit 1'], dirname(__FILE__)));
        $this->assertNotAsyncCommands(new CommandSet(['exit 1'], dirname(__FILE__), 1));
        $this->assertNotAsyncCommands(new CommandSet(['exit 1'], dirname(__FILE__), 2));
        $this->assertNotAsyncCommands(new CommandSet(['exit 1'], dirname(__FILE__), 20));
        $this->assertNotAsyncCommands(new CommandSet(['commands/echo', 'exit 2'], dirname(__FILE__)));
        $this->assertNotAsyncCommands(new CommandSet(['commands/flock', 'commands/echo', 'echo 1'], dirname(__FILE__), 2));
    }
}
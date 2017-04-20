<?php

use PHPUnit\Framework\TestCase;
use Mnvx\PProcess\Command\CommandSet;
use Mnvx\PProcess\Constraint\AsyncCommands;

class AsyncCommandsTest extends TestCase
{
    /**
     * @var AsyncCommands
     */
    protected $constraint;

    /**
     * @var string
     */
    protected $path;

    public function setUp()
    {
        $this->constraint = new AsyncCommands();
        $this->path = dirname(dirname(__FILE__)); //tests
    }

    public function testExit1String()
    {
        $this->assertFalse($this->constraint->matches(new CommandSet(['exit 1', 'exit 2'])));
        $this->assertFalse($this->constraint->matches(new CommandSet(['exit 1', 'exit 2'], '.', 1)));
    }

    public function testCommandExit1()
    {
        $this->assertFalse($this->constraint->matches(new CommandSet(['commands/exit1'], $this->path)));
        $this->assertFalse($this->constraint->matches(new CommandSet(['commands/exit1', 'commands/flock'], $this->path)));
    }

    public function testCommandFlock()
    {
        $this->assertTrue($this->constraint->matches(new CommandSet(['commands/flock'], $this->path, 1)));
        $this->assertTrue($this->constraint->matches(new CommandSet(['commands/flock', 'commands/echo'], $this->path, 1)));
        $this->assertFalse($this->constraint->matches(new CommandSet(['commands/flock'], $this->path, 2)));
        $this->assertFalse($this->constraint->matches(new CommandSet(['commands/flock'], $this->path, 3)));
    }

    public function testEcho1()
    {
        $this->assertTrue($this->constraint->matches(new CommandSet(['echo 1', 'echo 2'])));
    }

    public function testCommandEcho()
    {
        $this->assertTrue($this->constraint->matches(new CommandSet(['commands/echo'], $this->path)));
        $this->assertTrue($this->constraint->matches(new CommandSet(['commands/echo', 'echo 1'], $this->path)));
    }
}
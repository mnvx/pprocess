<?php

use PHPUnit\Framework\TestCase;
use Mnvx\PProcess\Command\Command;
use Mnvx\PProcess\Constraint\AsyncCommand;

class AsyncCommandTest extends TestCase
{
    /**
     * @var AsyncCommand
     */
    protected $constraint;

    /**
     * @var string
     */
    protected $path;

    public function setUp()
    {
        $this->constraint = new AsyncCommand();
        $this->path = dirname(dirname(__FILE__)); //tests
    }

    public function testExit1String()
    {
        $this->assertFalse($this->constraint->matches(new Command('exit 1')));
    }

    public function testCommandExit1()
    {
        $this->assertFalse($this->constraint->matches(new Command('commands/exit1', $this->path)));
    }

    public function testCommandFlock()
    {
        $this->assertTrue($this->constraint->matches(new Command('commands/flock', $this->path, 1)));
        $this->assertFalse($this->constraint->matches(new Command('commands/flock', $this->path, 2)));
        $this->assertFalse($this->constraint->matches(new Command('commands/flock', $this->path, 3)));
    }

    public function testEcho1()
    {
        $this->assertTrue($this->constraint->matches(new Command('echo 1')));
    }

    public function testCommandEcho()
    {
        $this->assertTrue($this->constraint->matches(new Command('commands/echo', $this->path)));
    }
}
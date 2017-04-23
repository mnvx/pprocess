<?php

namespace Mnvx\PProcess\Command;

/**
 * Description of command for assertions
 */
class Command
{
    /**
     * @var string Command for testing
     */
    protected $command;

    /**
     * @var string Path where command will be run
     */
    protected $path;

    /**
     * @var int How many times to run the command
     */
    protected $count;

    /**
     * Command constructor.
     * @param string $command Command for testing
     * @param string $path Path where command will be run
     * @param int|null $count How many times to run the command
     */
    public function __construct(string $command, string $path = null, int $count = null)
    {
        $this->command = $command;
        $this->path = $path;
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    public function __toString()
    {
        return \sprintf(
            '%s (path: %s, count: %s)',
            $this->getCommand(),
            $this->getPath() ?: 'not set',
            $this->getCount() ?: 'not set'
        );
    }

}
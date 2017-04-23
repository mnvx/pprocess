<?php

namespace Mnvx\PProcess\Command;

/**
 * Description of command set for assertions
 */
class CommandSet
{
    /**
     * @var string[] Commands for testing
     */
    protected $commands;

    /**
     * @var string Path where commands will be run
     */
    protected $path;

    /**
     * @var int How many times to run commands
     */
    protected $count;

    /**
     * Command constructor.
     * @param string[] $commands Commands for testing
     * @param string $path Path where commands will be run
     * @param int|null $count How many times to run commands
     */
    public function __construct(array $commands, string $path = null, int $count = null)
    {
        $this->commands = $commands;
        $this->path = $path;
        $this->count = $count;
    }

    /**
     * @return string[]
     */
    public function getCommands()
    {
        return $this->commands;
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
            implode(', ', $this->getCommands()),
            $this->getPath() ?: 'not set',
            $this->getCount() ?: 'not set'
        );
    }

}
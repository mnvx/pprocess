<?php

namespace Mnvx\PProcess\Constraint;

use Mnvx\PProcess\Command\CommandSet;
use Mnvx\PProcess\PProcessException;
use Symfony\Component\Process\Process;

class AsyncCommands extends AbstractAsyncConstraint
{
    /**
     * @var string|null Error description
     */
    protected $errorDescription = null;

    /**
     * @inheritdoc
     *
     * @param CommandSet $other
     */
    public function matches($other)
    {
        if (!($other instanceof CommandSet))
        {
            throw new PProcessException('Argument for matching must be instance of CommandSet');
        }

        $countParam = $other->getCount() ? '--processes=' . $other->getCount() : '';
        $commandParam = sprintf('%s --stdin %s', $this->getPProcessPath(), $countParam);
        $inputCommands = "printf '" . implode("\n", $other->getCommands()) . "\n'";

        $process = new Process($inputCommands . ' | ' . $commandParam, $other->getPath());
        $result = $process->run();
        $this->errorDescription = $process->getErrorOutput();

        return 0 === $result;
    }

    /**
     * @inheritdoc
     */
    protected function failureDescription($other)
    {
        return sprintf(
            "commands \n\t%s\nexecuted in parallel.\nOutput:\n%s",
            $other,
            $this->errorDescription
        );
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return 'execution of commands in parallel';
    }

}
<?php

namespace Mnvx\PProcess\Constraint;

use Mnvx\PProcess\Command\Command;
use Mnvx\PProcess\PProcessException;
use Symfony\Component\Process\Process;

class AsyncCommand extends AbstractAsyncConstraint
{
    /**
     * @var string|null Error description
     */
    protected $errorDescription = null;

    /**
     * @inheritdoc
     *
     * @param Command $other
     */
    public function matches($other)
    {
        if (!($other instanceof Command))
        {
            throw new PProcessException('Argument for matching must me instance of \\PProcess\\Command');
        }

        $commandParam = $other->getCommand() ? '--command="' . $other->getCommand() . '"' : '';
        $countParam = $other->getCount() ? '--processes=' . $other->getCount() : '';

        $command = sprintf('%s %s %s', $this->getPProcessPath(), $commandParam, $countParam);

        $process = new Process($command, $other->getPath());
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
            "command \n\t%s\nexecuted in parallel.\nOutput:\n%s",
            $other,
            $this->errorDescription
        );
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return 'execution of command in parallel';
    }

}
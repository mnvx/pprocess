<?php

namespace Mnvx\PProcess\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

abstract class AbstractAsyncConstraint extends Constraint
{
    protected function getPProcessPath()
    {
        return dirname(dirname(dirname(__FILE__))) . '/bin/pprocess';
    }
}
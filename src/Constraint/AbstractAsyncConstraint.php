<?php

namespace Mnvx\PProcess\Constraint;

use PHPUnit_Framework_Constraint as Constraint;

abstract class AbstractAsyncConstraint extends Constraint
{
    protected function getPProcessPath()
    {
        return dirname(dirname(dirname(__FILE__))) . '/bin/pprocess';
    }
}
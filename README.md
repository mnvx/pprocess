PProcess
========
[![Build Status](https://travis-ci.org/mnvx/pprocess.png?branch=master)](https://travis-ci.org/mnvx/pprocess)
[![MIT Licence](https://badges.frapsoft.com/os/mit/mit.svg?v=103)](https://opensource.org/licenses/mit-license.php)

Execution of processes in async mode for tests.

This extension for PhpUnit will help you to test bugs in processes
which are executing in async mode. PProcess will help you to test
deadlocks, conflicts with duplicate keys 
and other bugs in async processes.

Usage
-----

```php
<?php

use PHPUnit\Framework\TestCase;
use Mnvx\PProcess\Command\Command;
use Mnvx\PProcess\AsyncTrait;

/**
 * Class AsyncTest
 *
 * @use ./vendor/bin/phpunit tests/AsyncTest.php
 */
class AsyncTest extends TestCase
{
    use AsyncTrait;

    public function testCommandMustBeExecutedInAsyncMode()
    {
        // For Laravel
        $testCommand = "php artisan my-command-one --env=testing";
        $this->assertAsyncCommand(new Command($testCommand, dirname(dirname(__FILE__)), 5));
    }

    public function testCommandMustNotBeExecutedInAsyncMode()
    {
        // For Symfony
        $testCommand = "bin/console my-command-two --env=testing";
        $this->assertNotAsyncCommand(new Command($testCommand, dirname(dirname(__FILE__)), 5));
    }

}
```

Requirements
------------

* Linux or MacOS. Windows is not supported.
* PHP 5.5+

Installation
------------

Using composer:

```bash
composer require mnvx/pprocess --dev
```

License
-------

Released under the MIT license
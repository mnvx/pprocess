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
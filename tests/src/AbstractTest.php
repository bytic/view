<?php

declare(strict_types=1);

namespace Nip\View\Tests;

use PHPUnit\Framework\TestCase;
use UnitTester;

/**
 * Class AbstractTest.
 */
abstract class AbstractTest extends TestCase
{
    protected $object;

    /**
     * @var UnitTester
     */
    protected $tester;
}

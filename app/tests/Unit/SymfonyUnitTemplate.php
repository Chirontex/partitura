<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit;

use Codeception\Module\Symfony;
use Codeception\Test\Unit;
use Partitura\Tests\UnitTester;

abstract class SymfonyUnitTemplate extends Unit
{
    protected UnitTester $tester;

    protected Symfony $symfony;

    protected function _before(): void
    {
        $this->symfony->_before($this);
    }

    protected function _after(): void
    {
        $this->symfony->_after($this);
    }

    protected function _inject(Symfony $symfony): void
    {
        $this->symfony = $symfony;
    }
}

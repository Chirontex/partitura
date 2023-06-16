<?php

declare(strict_types=1);

namespace Partitura\Tests\Traits;

trait GenerateUsernameTrait
{
    use GenerateStringTrait;

    private function generateUsername(int $length = 10): string
    {
        return $this->generateString($length, range('a', 'z'));
    }
}

<?php

declare(strict_types=1);

namespace Partitura\Tests\Traits;

trait GeneratePasswordTrait
{
    use GenerateStringTrait;

    private function generatePassword(int $length = 10): string
    {
        return $this->generateString(
            $length,
            array_merge(range('a', 'z'), range(0, 9))
        );
    }
}

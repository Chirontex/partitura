<?php

declare(strict_types=1);

namespace Partitura\Tests\Traits;

trait GenerateStringTrait
{
    private function generateString(int $length, array $chars): string
    {
        $string = [];

        for ($i = 0; $i < $length; ++$i) {
            $string[] = $chars[rand(0, count($chars) - 1)];
        }

        return implode('', $string);
    }
}

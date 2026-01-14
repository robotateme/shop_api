<?php
declare(strict_types=1);

namespace App\Tests;

use App\Value\AddPercentValue;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AddPercentValueTest extends TestCase
{
    public static function additionProvider(): array
    {
        return [
            [100, 20, 120.0],
            [100.05, 30, 130.07],
            [100.05, 55, 155.08],
            [10, 20, 12],
            [1000, 20, 1200],
            [100.0, 0, 100.0],
        ];
    }

    #[DataProvider('additionProvider')]
    #[NoReturn] public function testAddPercentValue(int|float $price, int $percent, float $expected): void
    {
        $result = new AddPercentValue($price, $percent)->getValue();
        $this->assertEquals($expected, $result);
    }
}

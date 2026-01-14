<?php
declare(strict_types=1);
namespace App\Tests;

use App\Value\AddPercentValue;
use App\Value\SubPercentValue;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SubPercentValueTest extends TestCase
{
    public static function additionProvider(): array
    {
        return [
            [100, 20, 80.00],
            [100.05, 30, 70.04],
            [100.05, 55, 45.02],
            [100.0, 0, 100.0],
        ];
    }

    #[DataProvider('additionProvider')]
    #[NoReturn] public function testSubPercentValue(int|float $price, int $percent, float $expected): void
    {
        $result = new SubPercentValue($price, $percent)->getValue();
        $this->assertEquals($expected, $result);
    }
}

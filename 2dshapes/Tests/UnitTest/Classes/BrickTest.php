<?php

declare(strict_types=1);

namespace Shapes\Tests\UnitTests\Classes;

use PHPUnit\Framework\TestCase;
use Shapes\Brick;

class BrickTest extends TestCase
{

    /**
     * @dataProvider sizeProvider
     */
    public function testGetHeight(int $width, int $height): void
    {
        $brick = new Brick($width, $height);
        $this->assertEquals($height, $brick->getHeight());
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testIsRotatable(int $width, int $height): void
    {
        $brick = new Brick($width, $height);
        $this->assertEquals(($width == $height), $brick->isRotatable());
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testRotate(int $width, int $height): void
    {
        $brick = new Brick($width, $height);
        $brick->rotate();
        $this->assertEquals($height, $brick->getWidth());
        $this->assertEquals($width, $brick->getHeight());
    }

    /**
     * @dataProvider sizeProvider
     */
    public function testGetWidth(int $width, int $height): void
    {
        $brick = new Brick($width, $height);
        $this->assertEquals($width, $brick->getWidth());
    }

    /**
     * @dataProvider sizeAndTypeProvider
     */
    public function testGetType(int $width, int $height, string $type): void
    {
        $brick = new Brick($width, $height);
        $this->assertEquals($type, $brick->getType());
    }

    /**
     * @dataProvider sizeAndMatrixProvider
     */
    public function testGetMatrixString(int $width, int $height, string $matrix): void
    {
        $brick = new Brick($width, $height);
        $this->assertEquals($matrix, $brick->getMatrixString());
    }

    /**
     * @return array<array<int>>
     */
    public function sizeProvider(): array
    {
        return [
            [1, 1],
            [2, 5],
            [10, 4],
            [6, 6],
        ];
    }

    /**
     * @return array<array<int|string>>
     */
    public function sizeAndTypeProvider(): array
    {
        return [
            [1, 1, '1|1'],
            [2, 5, '5|2'],
            [10, 4, '10|4'],
            [6, 6, '6|6'],
        ];
    }

    /**
     * @return iterable<array<int|string>>
     */
    public function sizeAndMatrixProvider(): iterable
    {
        yield [1, 1, '1'];

        $matrix = <<<'MATRIX'
11
11
11
11
11
MATRIX;
        yield [2, 5, $matrix];

        yield [3, 1, '111'];
    }
}

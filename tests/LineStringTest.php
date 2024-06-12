<?php

use PHPUnit\Framework\TestCase;
use Vancuren\PhpTurf\PhpTurf\LineString;
use Vancuren\PhpTurf\PhpTurf\Point;

class LineStringTest extends TestCase
{
    public function testGetPoints()
    {
        $points = [
            [0, 0],
            [1, 1],
            [2, 2]
        ];

        $lineString = new LineString($points);
        $result = $lineString->getPoints();

        $this->assertEquals($points, $result);
    }
}

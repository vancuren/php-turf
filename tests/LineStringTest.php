<?php

use PHPUnit\Framework\TestCase;
use Vancuren\PhpTurf\PhpTurf\LineString;
use Vancuren\PhpTurf\PhpTurf\Point;

class LineStringTest extends TestCase
{
    public function testGetPoints()
    {
        $points = [
            new Point(0, 0),
            new Point(1, 1),
            new Point(2, 2)
        ];

        $lineString = new LineString($points);
        $result = $lineString->getPoints();

        $this->assertEquals($points, $result);
    }
}

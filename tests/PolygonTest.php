<?php

use PHPUnit\Framework\TestCase;

use Vancuren\PhpTurf\PhpTurf\Point;
use Vancuren\PhpTurf\PhpTurf\Polygon;

class PolygonTest extends TestCase
{
    public function testArea()
    {
        $vertices = [
            new Point(0, 0),
            new Point(4, 0),
            new Point(4, 3),
            new Point(0, 3)
        ];

        $polygon = new Polygon($vertices);
        $area = $polygon->area();

        $this->assertEquals(12, $area);
    }

    public function testContainsPoint()
    {
        $vertices = [
            new Point(0, 0),
            new Point(4, 0),
            new Point(4, 3),
            new Point(0, 3)
        ];

        $polygon = new Polygon($vertices);

        $insidePoint = new Point(2, 2);
        $outsidePoint = new Point(5, 5);

        $this->assertTrue($polygon->containsPoint($insidePoint));
        $this->assertFalse($polygon->containsPoint($outsidePoint));
    }
}

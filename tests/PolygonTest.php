<?php

use PHPUnit\Framework\TestCase;

use Vancuren\PhpTurf\PhpTurf\Point;
use Vancuren\PhpTurf\PhpTurf\Polygon;

class PolygonTest extends TestCase
{

    public function testContainsPoint()
    {
        $vertices = [
            [
                [0, 0],
                [0, 4],
                [3, 4],
                [3, 0],
                [0, 0]
            ]
        ];

        $polygon = new Polygon($vertices);

        $insidePoint = new Point([2, 2]);
        $outsidePoint = new Point([5, 5]);

        $this->assertTrue($polygon->containsPoint($insidePoint));
        $this->assertFalse($polygon->containsPoint($outsidePoint));
    }

    public function testGetGeometry()
    {
        $vertices = [
            [
                [0, 0],
                [0, 4],
                [3, 4],
                [3, 0],
                [0, 0] // Closing point
            ]
        ];

        $polygon = new Polygon($vertices);
        $geometry = $polygon->getGeometry();

        $expected = [
            "type" => "Polygon",
            "coordinates" => [
                [
                    [0, 0],
                    [0, 4],
                    [3, 4],
                    [3, 0],
                    [0, 0]
                ]
            ]
        ];
        $this->assertEquals($expected, $geometry);
    }

    public function testToGeoJSON()
    {
        $vertices = [
            [
                [0, 0],
                [0, 4],
                [3, 4],
                [3, 0],
                [0, 0],
            ]
        ];

        $polygon = new Polygon($vertices);

        $actual = $polygon->toGeoJSON();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [[0, 0], [0, 4], [3, 4], [3, 0], [0, 0]]
                ]
            ],
            'properties' => []
        ];

        $this->assertEquals(json_encode($expected), json_encode($actual));
    }    
}

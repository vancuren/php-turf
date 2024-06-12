<?php

use PHPUnit\Framework\TestCase;
use Vancuren\PhpTurf\PhpTurf\Point;

class PointTest extends TestCase
{

    public function testGetGeometry()
    {
        $point = new Point([-73.9864, 40.7486]); // New York, NY

        $actual = $point->getGeometry();

        $expected = [
            'type' => 'Point',
            'coordinates' => [-73.9864, 40.7486]
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testToGeoJSON()
    {
        $point = new Point([-73.9864, 40.7486]); // New York, NY

        $actual = $point->toGeoJSON();

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [-73.9864, 40.7486]
            ],
            'properties' => []
        ];
        $this->assertEquals(json_encode($expected), json_encode($actual));
    }

    public function testToGeoJSONWithProperties()
    {
        $point = new Point([-73.9864, 40.7486]); // New York, NY

        $actual = $point->toGeoJSON(['name' => 'New York']);

        $expected = [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [-73.9864, 40.7486]
            ],
            'properties' => ['name' => 'New York']
        ];
        $this->assertEquals(json_encode($expected), json_encode($actual));
    }

    public function testToString()
    {
        $point = new Point([-73.9864, 40.7486]); // New York, NY

        $this->assertEquals('(40.7486, -73.9864)', $point->toString());
    }

    public function testToArray()
    {
        $point = new Point([-73.9864, 40.7486]); // New York, NY

        $this->assertEquals([40.7486, -73.9864], $point->toArray());
    }
}

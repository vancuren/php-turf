<?php

use PHPUnit\Framework\TestCase;
use Vancuren\PhpTurf\PhpTurf\Point;

class PointTest extends TestCase
{
    public function testDistance()
    {
        $point1 = new Point(40.7486, -73.9864); // New York, NY
        $point2 = new Point(34.0522, -118.2437); // Los Angeles, CA

        $distance = Point::distance($point1, $point2);

        $this->assertEquals(3937139.7530509853, $distance, 'Error'); // Roughly 3944 km
    }

    public function testMidpoint()
    {
        $point1 = new Point(40.7486, -73.9864); // New York, NY
        $point2 = new Point(34.0522, -118.2437); // Los Angeles, CA

        $midpoint = Point::midpoint($point1, $point2);

        $precision = 3;

        $lat = number_format((float) $midpoint->latitude, $precision, '.', '');
        $lng = number_format((float) $midpoint->longitude, $precision, '.', '');
        
        $this->assertEquals(39.530, $lat, '', 0.1);
        $this->assertEquals(-97.157, $lng, '', 0.1);
    }

    public function testBearing()
    {
        $point1 = new Point(40.7486, -73.9864); // New York, NY
        $point2 = new Point(34.0522, -118.2437); // Los Angeles, CA

        $bearing = Point::bearing($point1, $point2);

        $this->assertEquals(273.648314605432, $bearing, '', 1); // Roughly 273 degrees
    }

    public function testDestination()
    {
        $point = new Point(40.7486, -73.9864); // New York, NY
        $distance = 3944; // Roughly the distance to Los Angeles, CA
        $bearing = 273; // Bearing to Los Angeles, CA

        $destination = Point::destination($point, $distance, $bearing);

        $this->assertEquals(33.68433652664773, $destination->latitude, 'Incorrect destination latitude');
        $this->assertEquals(-118.12453281408274, $destination->longitude, 'Incorrect destination longitude');
    }
    
    public function testNearestPoint()
    {
        $referencePoint = new Point(40.7486, -73.9864); // New York, NY

        $points = [
            new Point(34.0522, -118.2437), // Los Angeles, CA
            new Point(41.8781, -87.6298),  // Chicago, IL
            new Point(29.7604, -95.3698)   // Houston, TX
        ];

        $nearestPoint = Point::nearestPoint($referencePoint, $points);

        $this->assertEquals(41.8781, $nearestPoint->latitude, '', 0.1); // Chicago, IL
        $this->assertEquals(-87.6298, $nearestPoint->longitude, '', 0.1);
    }

    public function testGetGeometry()
    {
        $point = new Point(40.7486, -73.9864); // New York, NY

        $actual = $point->getGeometry();

        $expected = [
            'type' => 'Point',
            'coordinates' => [-73.9864, 40.7486]
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testToGeoJSON()
    {
        $point = new Point(40.7486, -73.9864); // New York, NY

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
        $point = new Point(40.7486, -73.9864); // New York, NY

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
        $point = new Point(40.7486, -73.9864); // New York, NY

        $this->assertEquals('(40.7486, -73.9864)', $point->toString());
    }

    public function testToArray()
    {
        $point = new Point(40.7486, -73.9864); // New York, NY

        $this->assertEquals([40.7486, -73.9864], $point->toArray());
    }
}

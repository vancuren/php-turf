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

        $this->assertEquals(39.530415216651974, $midpoint->latitude, '', 0.1);
        $this->assertEquals(-97.15709254069252, $midpoint->longitude, '', 0.1);
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
}

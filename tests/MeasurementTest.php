<?php

use PHPUnit\Framework\TestCase;
use Vancuren\PhpTurf\PhpTurf\FeatureCollection;
use Vancuren\PhpTurf\PhpTurf\LineString;
use Vancuren\PhpTurf\PhpTurf\Measurement;
use Vancuren\PhpTurf\PhpTurf\Point;
use Vancuren\PhpTurf\PhpTurf\Polygon;

class MeasurementTest extends TestCase 
{
    public function testAlong()
    {
        $line = new LineString([
            [-77.031669, 38.878605],
            [-77.029609, 38.881946],
            [-77.020339, 38.884084],
            [-77.025661, 38.885821],
            [-77.021884, 38.889563],
            [-77.019824, 38.892368]
        ]);
    
        $distance = 0.5; // Half a kilometer
        $point = Measurement::along($line, $distance);
    
        $this->assertEquals(38.882658816636734, $point->geometry['coordinates'][1], 'Measurement::along() did not return correct latitude');
        $this->assertEquals(-77.02916946222722, $point->geometry['coordinates'][0], 'Measurement::along() did not return correct longitude');
    }    

    public function testArea()
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
        $area = Measurement::area($polygon);

        $this->assertEquals(148583583306.06003, $area);
    }

    public function testBearing()
    {
        $point1 = new Point([-73.9864, 40.7486]); // New York, NY
        $point2 = new Point([-118.2437, 34.0522]); // Los Angeles, CA        

        $bearing = Measurement::bearing($point1, $point2);

        $this->assertEquals(273.648314605432, $bearing, 'Measurement::bearing did not return the correct value.'); // Roughly 273 degrees
    }

    public function testCenter() 
    {
            $points = [
                new Point([-73.9864, 40.7486]), // New York, NY
                new Point([-118.2437, 34.0522]), // Los Angeles, CA
                new Point([-87.6298, 41.8781]), // Chicago, IL
                new Point([-95.3698, 29.7604]) // Houston, TX
            ];
        
            $featureCollection = new FeatureCollection($points);
            $center = Measurement::center($featureCollection);
        
            $this->assertEquals(36.609825, $center->geometry['coordinates'][1], 'Measurement::center did not return the correct latitude.');
            $this->assertEquals(-93.807425, $center->geometry['coordinates'][0], 'Measurement::center did not return the correct longitude.');
    }

    public function testDistance()
    {
        $point1 = new Point([-73.9864, 40.7486]); // New York, NY
        $point2 = new Point([-118.2437, 34.0522]); // Los Angeles, CA

        $distance = Measurement::distance($point1, $point2);

        $this->assertEquals(3937139.7530509853, $distance, 'Error'); // Roughly 3944 km
    }

    public function testDestination()
    {
        $point = new Point([-73.9864, 40.7486]); // New York, NY
        $distance = 3944; // Roughly the distance to Los Angeles, CA
        $bearing = 273; // Bearing to Los Angeles, CA

        $destination = Measurement::destination($point, $distance, $bearing);

        $this->assertEquals(33.68433652664773, $destination->geometry['coordinates'][1], 'Incorrect destination latitude');
        $this->assertEquals(-118.12453281408274, $destination->geometry['coordinates'][0], 'Incorrect destination longitude');
    }
    

    public function testMidpoint()
    {
        $point1 = new Point([-73.9864, 40.7486]); // New York, NY
        $point2 = new Point([-118.2437, 34.0522]); // Los Angeles, CA

        $midpoint = Measurement::midpoint($point1, $point2);

        $precision = 3;

        $lat = number_format((float) $midpoint->geometry['coordinates'][1], $precision, '.', '');
        $lng = number_format((float) $midpoint->geometry['coordinates'][0], $precision, '.', '');
        
        $this->assertEquals(39.530, $lat, 'Measurement::midpoint did not return the correct latitude.');
        $this->assertEquals(-97.157, $lng, 'Measurement::midpoint did not return the correct longitude.');
    }

    public function testNearestPoint()
    {
        $referencePoint = new Point([-73.9864, 40.7486]); // New York, NY
    
        $points = [
            new Point([-118.2437, 34.0522]), // Los Angeles, CA
            new Point([-87.6298, 41.8781]),  // Chicago, IL
            new Point([-95.3698, 29.7604])   // Houston, TX
        ];

        $nearestPoint = Measurement::nearestPoint($referencePoint, $points);

        $this->assertEquals(41.8781, $nearestPoint->geometry['coordinates'][1], 'Measurement::nearestPoint did not return the correct latitude.'); // Chicago, IL
        $this->assertEquals(-87.6298, $nearestPoint->geometry['coordinates'][0], 'Measurement::nearestPoint did not return the correct longitude.');
    }
}
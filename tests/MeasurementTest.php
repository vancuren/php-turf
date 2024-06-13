<?php

use PHPUnit\Framework\TestCase;
use Vancuren\PhpTurf\PhpTurf\FeatureCollection;
use Vancuren\PhpTurf\PhpTurf\Measurement;
use Vancuren\PhpTurf\PhpTurf\Point;
use Vancuren\PhpTurf\PhpTurf\Polygon;

class MeasurementTest extends TestCase 
{

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

      $this->assertEquals(12, $area);
  }

  public function testBearing()
  {
      $point1 = new Point([-73.9864, 40.7486]); // New York, NY
      $point2 = new Point([-118.2437, 34.0522]); // Los Angeles, CA        

      $bearing = Measurement::bearing($point1, $point2);

      $this->assertEquals(273.648314605432, $bearing, '', 1); // Roughly 273 degrees
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
    
        $this->assertEquals(36.609825, $center->geometry['coordinates'][1], '', 0.1);
        $this->assertEquals(-93.807425, $center->geometry['coordinates'][0], '', 0.1);
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
      
      $this->assertEquals(39.530, $lat, '', 0.1);
      $this->assertEquals(-97.157, $lng, '', 0.1);
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

      $this->assertEquals(41.8781, $nearestPoint->geometry['coordinates'][1], '', 0.1); // Chicago, IL
      $this->assertEquals(-87.6298, $nearestPoint->geometry['coordinates'][0], '', 0.1);
  }
}
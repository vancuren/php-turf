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
      $vertices = [[[-74.70109747586054,41.34703391012417],[-75.1154154702147,41.00106265111975],[-75.08952059556759,40.800444702324626],[-75.17367893817084,40.54512767286903],[-74.72051863184561,40.13557875332302],[-75.49736487126017,39.71856727542951],[-75.45852255928958,39.389135419222214],[-74.87588787972854,39.15358719056758],[-74.94709878500822,38.92228456910766],[-74.22851601354982,39.63386322222158],[-73.95014611109305,40.407244517621535],[-74.26088460685888,40.50083896910817],[-73.86598776848983,40.99129052935143],[-74.70109747586054,41.34703391012417]]];

    $polygon = new Polygon($vertices);
    $area = Measurement::area($polygon);

    $this->assertEquals(19101105715.63988, $area);
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
<?php

namespace Vancuren\PhpTurf\PhpTurf;

class Measurement {

  public function __construct() { }

  public static function area($feature)
  {
      $vertices = $feature->geometry['coordinates'][0];
      $numVertices = count($vertices);
      $area = 0;

      for ($i = 0, $j = $numVertices - 1; $i < $numVertices; $j = $i++) {
          $xi = $vertices[$i][0];
          $yi = $vertices[$i][1];
          $xj = $vertices[$j][0];
          $yj = $vertices[$j][1];
          $area += ($xi + $xj) * ($yj - $yi);
      }

      $area = abs($area) / 2.0;
      return $area;
  }

  // Calculate the bearing between two points
  public static function bearing(Point $point1, Point $point2)
  {
      $lat1 = deg2rad($point1->geometry['coordinates'][1]);
      $lat2 = deg2rad($point2->geometry['coordinates'][1]);
      $lon1 = deg2rad($point1->geometry['coordinates'][0]);
      $lon2 = deg2rad($point2->geometry['coordinates'][0]);

      $y = sin($lon2 - $lon1) * cos($lat2);
      $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($lon2 - $lon1);
      $bearing = rad2deg(atan2($y, $x));

      return fmod($bearing + 360, 360.0);
  }

  // Calculate the distance between two points
  public static function distance(Point $point1, Point $point2)
  {
      $earthRadius = 6371000; // meters

      $latFrom = deg2rad($point1->geometry['coordinates'][1]);
      $lonFrom = deg2rad($point1->geometry['coordinates'][0]);
      $latTo = deg2rad($point2->geometry['coordinates'][1]);
      $lonTo = deg2rad($point2->geometry['coordinates'][0]);

      $latDelta = $latTo - $latFrom;
      $lonDelta = $lonTo - $lonFrom;

      $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
          cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
      return $angle * $earthRadius;
  }

  // Calculate the midpoint between two points
  public static function midpoint(Point $point1, Point $point2)
  {
      $lat1 = deg2rad($point1->geometry['coordinates'][1]);
      $lon1 = deg2rad($point1->geometry['coordinates'][0]);
      $lat2 = deg2rad($point2->geometry['coordinates'][1]);

      $dLon = deg2rad($point2->geometry['coordinates'][0] - $point1->geometry['coordinates'][0]);

      $bx = cos($lat2) * cos($dLon);
      $by = cos($lat2) * sin($dLon);
      $lat3 = atan2(sin($lat1) + sin($lat2),
                    sqrt((cos($lat1) + $bx) * (cos($lat1) + $bx) + $by * $by));
      $lon3 = $lon1 + atan2($by, cos($lat1) + $bx);

      return new Point([rad2deg($lon3), rad2deg($lat3)]);
  }

  // Calculate the destination point from a given point, distance, and bearing
  public static function destination(Point $point, $distance, $bearing, $units = 'kilometers')
  {
      $earthRadius = ($units === 'miles') ? 3958.8 : 6371; // miles or kilometers

      $lat = deg2rad($point->geometry['coordinates'][1]);
      $lon = deg2rad($point->geometry['coordinates'][0]);
      $bearing = deg2rad($bearing);

      $lat2 = asin(sin($lat) * cos($distance / $earthRadius) +
                    cos($lat) * sin($distance / $earthRadius) * cos($bearing));

      $lon2 = $lon + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat),
                            cos($distance / $earthRadius) - sin($lat) * sin($lat2));

      return new Point([rad2deg($lon2), rad2deg($lat2)]);
  }

  // Find the nearest point to a reference point
  public static function nearestPoint(Point $referencePoint, array $points)
  {
      $nearestPoint = null;
      $shortestDistance = PHP_FLOAT_MAX;

      foreach ($points as $point) {
          $distance = self::distance($referencePoint, $point);
          if ($distance < $shortestDistance) {
              $shortestDistance = $distance;
              $nearestPoint = $point;
          }
      }

      return $nearestPoint;
  }

}
<?php

namespace Vancuren\PhpTurf\PhpTurf;

class Point {
    public $latitude;
    public $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    // Calculate the distance between two points
    public static function distance(Point $point1, Point $point2)
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($point1->latitude);
        $lonFrom = deg2rad($point1->longitude);
        $latTo = deg2rad($point2->latitude);
        $lonTo = deg2rad($point2->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    // Calculate the midpoint between two points
    public static function midpoint(Point $point1, Point $point2)
    {
        $lat1 = deg2rad($point1->latitude);
        $lon1 = deg2rad($point1->longitude);
        $lat2 = deg2rad($point2->latitude);

        $dLon = deg2rad($point2->longitude - $point1->longitude);

        $bx = cos($lat2) * cos($dLon);
        $by = cos($lat2) * sin($dLon);
        $lat3 = atan2(sin($lat1) + sin($lat2),
                      sqrt((cos($lat1) + $bx) * (cos($lat1) + $bx) + $by * $by));
        $lon3 = $lon1 + atan2($by, cos($lat1) + $bx);

        return new Point(rad2deg($lat3), rad2deg($lon3));
    }

    // Calculate the bearing between two points
    public static function bearing(Point $point1, Point $point2)
    {
        $lat1 = deg2rad($point1->latitude);
        $lat2 = deg2rad($point2->latitude);
        $lon1 = deg2rad($point1->longitude);
        $lon2 = deg2rad($point2->longitude);

        $y = sin($lon2 - $lon1) * cos($lat2);
        $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($lon2 - $lon1);
        $bearing = rad2deg(atan2($y, $x));

        return fmod($bearing + 360, 360.0);
    }
    
    // Calculate the destination point from a given point, distance, and bearing
    public static function destination(Point $point, $distance, $bearing, $units = 'kilometers')
    {
        $earthRadius = ($units === 'miles') ? 3958.8 : 6371; // miles or kilometers

        $lat = deg2rad($point->latitude);
        $lon = deg2rad($point->longitude);
        $bearing = deg2rad($bearing);

        $lat2 = asin(sin($lat) * cos($distance / $earthRadius) +
                      cos($lat) * sin($distance / $earthRadius) * cos($bearing));

        $lon2 = $lon + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat),
                              cos($distance / $earthRadius) - sin($lat) * sin($lat2));

        return new Point(rad2deg($lat2), rad2deg($lon2));
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

    public function getGeometry() {
        return [
            'type' => 'Point',
            'coordinates' => [$this->longitude, $this->latitude]
        ];
    }

    // Convert the point to a GeoJSON feature
    public function toGeoJSON($properties = [])
    {
        return [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$this->longitude, $this->latitude]
            ],
            'properties' => $properties
        ];
    }

    // Convert the point to a string
    public function toString()
    {
        return "($this->latitude, $this->longitude)";
    }

    // Convert the point to an array
    public function toArray()
    {
        return [$this->latitude, $this->longitude];
    }
}

<?php

namespace Vancuren\PhpTurf\PhpTurf;

class Point {
    public $type = 'Feature';

    public $geometry = [
        'type' => 'Point',
        'coordinates' => []
    ];

    public $properties = [];    

    public function __construct(array $coords, array $properties = [])
    {
        $longitude = $coords[0];
        $latitude = $coords[1];

        $this->geometry['coordinates'] = [$longitude, $latitude];
        $this->properties = $properties;
    }
    
    public function getGeometry() {
        return [
            'type' => 'Point',
            'coordinates' => [$this->geometry['coordinates'][0], $this->geometry['coordinates'][1]]
        ];
    }

    // Convert the point to a GeoJSON feature
    public function toGeoJSON($properties = [])
    {
        return [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$this->geometry['coordinates'][0], $this->geometry['coordinates'][1]]
            ],
            'properties' => $properties
        ];
    }

    // Convert the point to a string
    public function toString()
    {
        $latitude = $this->geometry['coordinates'][1];
        $longitude = $this->geometry['coordinates'][0];
        return "($latitude, $longitude)";
    }

    // Convert the point to an array
    public function toArray()
    {
        return [$this->geometry['coordinates'][1], $this->geometry['coordinates'][0]];
    }
}

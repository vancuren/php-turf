<?php

namespace Vancuren\PhpTurf\PhpTurf;

class Polygon {

    public $type = 'Feature';

    public $geometry = [
        'type' => 'Polygon',
        'coordinates' => [[]]
    ];

    public $properties = [];

    public function __construct(array $coords, array $properties = [])
    {
        $this->geometry['coordinates'] = $coords;
        $this->properties = $properties;
    }

    // public function area()
    // {
    //     $vertices = $this->geometry['coordinates'][0];
    //     $numVertices = count($vertices);
    //     $area = 0;

    //     for ($i = 0, $j = $numVertices - 1; $i < $numVertices; $j = $i++) {
    //         $xi = $vertices[$i][0];
    //         $yi = $vertices[$i][1];
    //         $xj = $vertices[$j][0];
    //         $yj = $vertices[$j][1];
    //         $area += ($xi + $xj) * ($yj - $yi);
    //     }

    //     $area = abs($area) / 2.0;
    //     return $area;
    // }

    public function getVertices()
    {
        return $this->geometry['coordinates'][0];
    }

    public function containsPoint(Point $point)
    {
        $vertices = $this->geometry['coordinates'][0];
        $numVertices = count($vertices);
        $contains = false;

        for ($i = 0, $j = $numVertices - 1; $i < $numVertices; $j = $i++) {
            $xi = $vertices[$i][0];
            $yi = $vertices[$i][1];
            $xj = $vertices[$j][0];
            $yj = $vertices[$j][1];

            $intersect = (($yi > $point->geometry['coordinates'][1]) != ($yj > $point->geometry['coordinates'][1])) &&
                         ($point->geometry['coordinates'][0] < ($xj - $xi) * ($point->geometry['coordinates'][1] - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $contains = !$contains;
            }
        }

        return $contains;
    }

    public function getGeometry() 
    {
        return $this->geometry;
    }

    public function toGeoJSON()
    {
        return [
            'type' => 'Feature',
            'geometry' => $this->geometry,
            'properties' => $this->properties
        ];
    }
}

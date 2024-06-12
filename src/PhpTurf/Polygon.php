<?php

namespace Vancuren\PhpTurf\PhpTurf;

class Polygon {
    private $vertices;

    public function __construct(array $vertices)
    {
        $this->vertices = $vertices;
    }

    public function area()
    {
        $vertices = $this->vertices;
        $numVertices = count($vertices);
        $area = 0;

        for ($i = 0; $i < $numVertices; $i++) {
            $j = ($i + 1) % $numVertices;
            $area += $vertices[$i]->longitude * $vertices[$j]->latitude;
            $area -= $vertices[$j]->longitude * $vertices[$i]->latitude;
        }

        $area = abs($area) / 2.0;
        return $area;
    }

    public function getVertices()
    {
        return $this->vertices;
    }

    public function containsPoint(Point $point)
    {
        $vertices = $this->vertices;
        $numVertices = count($vertices);
        $contains = false;

        for ($i = 0, $j = $numVertices - 1; $i < $numVertices; $j = $i++) {
            if ((($vertices[$i]->latitude > $point->latitude) != ($vertices[$j]->latitude > $point->latitude)) &&
                ($point->longitude < ($vertices[$j]->longitude - $vertices[$i]->longitude) * ($point->latitude - $vertices[$i]->latitude) / ($vertices[$j]->latitude - $vertices[$i]->latitude) + $vertices[$i]->longitude)) {
                $contains = !$contains;
            }
        }

        return $contains;
    }

    public function getGeometry() 
    {
        $vertices = $this->vertices;
        $numVertices = count($vertices);
        $geometry = [];

        for ($i = 0; $i < $numVertices; $i++) {
            $geometry[] = [$vertices[$i]->longitude, $vertices[$i]->latitude];
        }

        $geometry[] = [$vertices[0]->longitude, $vertices[0]->latitude];

        return [
            'type' => 'Polygon',
            'coordinates' => [
                $geometry
            ]
        ];
    }

    public function toGeoJSON($properties = [])
    {
        $vertices = $this->vertices;
        $numVertices = count($vertices);
        $coordinates = [];

        for ($i = 0; $i < $numVertices; $i++) {
            $coordinates[] = [$vertices[$i]->longitude, $vertices[$i]->latitude];
        }

        $coordinates[] = [$vertices[0]->longitude, $vertices[0]->latitude];

        return [
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    $coordinates
                ]
            ],
            'properties' => $properties
        ];
    }
}

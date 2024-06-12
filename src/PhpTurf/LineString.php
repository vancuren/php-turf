<?php

namespace Vancuren\PhpTurf\PhpTurf;

class LineString {

    public $type = 'Feature';

    public $geometry = [
        'type' => 'LineString',
        'coordinates' => []
    ];

    public $properties = [];

    public function __construct(array $coords, array $properties = [])
    {
        $this->geometry['coordinates'] = $coords;
        $this->properties = $properties;
    }


    public function getPoints()
    {
        return $this->geometry['coordinates'];
    }
}

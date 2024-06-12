<?php

namespace Vancuren\PhpTurf\PhpTurf;

class LineString {
    private $points;

    public function __construct(array $points)
    {
        $this->points = $points;
    }

    public function getPoints()
    {
        return $this->points;
    }
}

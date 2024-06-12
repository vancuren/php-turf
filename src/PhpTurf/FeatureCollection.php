<?php

namespace Vancuren\PhpTurf\PhpTurf;

class FeatureCollection {

  public $type = 'FeatureCollection';
  public $features = [];


  public function __construct(array $features)
  {
      $this->features = $features;
  }
}
<?php

use PHPUnit\Framework\TestCase;
use Vancuren\PhpTurf\PhpTurf\FeatureCollection;

class FeatureCollectionTest extends TestCase 
{
    public function testFeatureCollection()
    {
        $features = [
            [
                "type" => "Feature",
                "properties" => [
                    "name" => "Coors Field",
                    "show_on_map" => true
                ],
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [-104.99404, 39.75621]
                ]
            ],
            [
                "type" => "Feature",
                "properties" => [
                    "name" => "Busch Field",
                    "show_on_map" => true
                ],
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [-104.98404, 39.74621]
                ]
            ]
        ];

        $featureCollection = new FeatureCollection($features);

        // print_r(PHP_EOL);
        // print_r(PHP_EOL);
        // print_r(PHP_EOL);
        // print_r(PHP_EOL);
        // print_r(PHP_EOL);
        // print_r(json_encode($featureCollection));
        // print_r(PHP_EOL);
        // print_r(PHP_EOL);
        // print_r(PHP_EOL);
        // print_r(PHP_EOL);

        $this->assertEquals('FeatureCollection', $featureCollection->type);
        $this->assertEquals($features, $featureCollection->features);
    }
}
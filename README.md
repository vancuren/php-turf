# PHP Turf

PHP Turf is a PHP library for geospatial analysis similar to Turf.js.

- [Installation](#installation)
- [Example](#example)
- [Usage](#usage)
- [Contributing](#contributing)

## Installation

You can install PHP Turf via Composer. Run the following command in your terminal:

```bash
composer require vancuren/php-turf
```

## Example

Here's a basic example demonstrating how to use PHP Turf to perform geospatial analysis:

```php
<?php

*require* 'vendor/autoload.php';

use Vancuren\PhpTurf\Point;

*// Create some points*
$point1 = new Point([-73.9864, 40.7486]); *// New York, NY*
$point2 = new Point([-118.2437, 34.0522]); *// Los Angeles, CA*

*// Calculate distance between points*
$distance = Measurement::distance($point1, $point2);
echo "Distance between New York and Los Angeles: " . $distance . " kilometers\n";
```

## Usage

### Helpers

#### Point

Creates a Point feature from a coordinate.

```php
$point1 = new Point([-73.9864, 40.7486]); // New York, NY*
$point2 = new Point([-118.2437, 34.0522]); // Los Angeles, CA*
```

#### Polygon

Creates a Polygon feature from an array of coordinates.

```php
$coords = [[[0, 0],[0, 4],[3, 4],[3, 0],[0, 0]]];

$polygon = new Polygon($coords);
```

#### LineString

Creates a new line string

```php
$points = [[0, 0],[1, 1],[2, 2]];

$lineString = new LineString($points);
```

#### FeatureCollection

Takes one or more Features and creates a FeatureCollection.

```php
$features = [ 
    new Point([1,2]),
    new Point([1,3]),
    new Point([1,4]),
    new Point([1,5])
];

$featureCollection = new FeatureCollection($features);
```

### Measurement

#### Area

Returns the polygon’s area

```php
$coords = [[[0, 0],[0, 4],[3, 4],[3, 0],[0, 0]]];

$polygon = new Polygon($coords);
$area = Measurement::area($polygon);
```

#### Bearing

Calculate the bearing between two points

```php
$point1 = new Point([-73.9864, 40.7486]); *// New York, NY*
$point2 = new Point([-118.2437, 34.0522]); *// Los Angeles, CA*

$bearing = Measurement::bearing($point1, $point2);
```

#### Destination

Calculate the destination point from a given point, distance, and bearing

```php
$point = new Point([-73.9864, 40.7486]); *// New York, NY*
$distance = 3944; *// Roughly the distance to Los Angeles, CA*
$bearing = 273; *// Bearing to Los Angeles, CA*

$destination = Measurement::destination($point, $distance, $bearing);
```

#### Distance

Calculate the distance between two points

```php
$point1 = new Point([-73.9864, 40.7486]); *// New York, NY*
$point2 = new Point([-118.2437, 34.0522]); *// Los Angeles, CA*

$distance = Measurement::distance($point1, $point2);
```

#### Midpoint

Calculate the midpoint between two points

```php
$point1 = new Point([-73.9864, 40.7486]); *// New York, NY*
$point2 = new Point([-118.2437, 34.0522]); *// Los Angeles, CA*

$midpoint = Measurement::midpoint($point1, $point2);
```

### Coordinate Mutation

TODO - Need to implement Coordinate Mutation ...

### Transformation

TODO - Need to implement Transformation ...

### Feature Conversion

TODO - Need to implement Feature Conversion ...

### Misc

#### Nearest Point

Find the nearest point to a reference point

```php
$referencePoint = new Point([-73.9864, 40.7486]); *// New York, NY*

$points = [
    new Point([-118.2437, 34.0522]), *// Los Angeles, CA*
    new Point([-87.6298, 41.8781]),  *// Chicago, IL*
    new Point([-95.3698, 29.7604])   *// Houston, TX*
];

$nearestPoint = Measurement::nearestPoint($referencePoint, $points);
```

#### Contains Point

Checks to see if a polygon contains a point

```php
$vertices = [[[0, 0],[0, 4],[3, 4],[3, 0],[0, 0]]];

$polygon = new Polygon($vertices);

$insidePoint = new Point([2, 2]);
$outsidePoint = new Point([5, 5]);

$isPointInside = $polygon->containsPoint($insidePoint); // TRUE
$isPointInside = $polygon->containsPoint($outsidePoint); // FALSE
```

### Random

### Misc

#### Get Points

Returns the points that create the line string.

```php
$points = [
    [0, 0],
    [1, 1],
    [2, 2]
];

$lineString = new LineString($points);
$result = $lineString->getPoints();
```
## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues if you encounter any problems or have suggestions for improvement.


## Backers

Thank you to all our backers! 🙏 

[Become a backer]()

## Sponsors

Support this project by becoming a sponsor. Your logo will show up here with a link to your website. 

[Become a sponsor]()

## License

This project is licensed under the GNU AGPLv3 License. See the [LICENSE](https://github.com/vancuren/php-turf/blob/main/LICENSE.md) file for details.

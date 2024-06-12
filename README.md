# PHP Turf

PHP Turf is a PHP library for geospatial analysis similar to Turf.js.

[Installation](#installation)
[Example](#example)
[Usage](#usage)
[Contributing](#contributing)

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
$point1 = new Point(40.7486, -73.9864); *// New York, NY*
$point2 = new Point(34.0522, -118.2437); *// Los Angeles, CA*

*// Calculate distance between points*
$distance = Point::distance($point1, $point2);
echo "Distance between New York and Los Angeles: " . $distance . " kilometers\n";
```

## Usage

### Point

Creates a geocoordinate point with a latitude and longitude.

#### Point

Creates a new point

```php
$point1 = new Point(40.7486, -73.9864); *// New York, NY*
$point2 = new Point(34.0522, -118.2437); *// Los Angeles, CA*
```

#### Distance

Calculate the distance between two points

```php
$point1 = new Point(40.7486, -73.9864); *// New York, NY*
$point2 = new Point(34.0522, -118.2437); *// Los Angeles, CA*

$distance = Point::distance($point1, $point2);
```

#### Midpoint

Calculate the midpoint between two points

```php
$point1 = new Point(40.7486, -73.9864); *// New York, NY*
$point2 = new Point(34.0522, -118.2437); *// Los Angeles, CA*

$midpoint = Point::midpoint($point1, $point2);
```

#### Bearing

Calculate the bearing between two points

```php
$point1 = new Point(40.7486, -73.9864); *// New York, NY*
$point2 = new Point(34.0522, -118.2437); *// Los Angeles, CA*

$bearing = Point::bearing($point1, $point2);
```

#### Destination

Calculate the destination point from a given point, distance, and bearing

```php
$point = new Point(40.7486, -73.9864); *// New York, NY*
$distance = 3944; *// Roughly the distance to Los Angeles, CA*
$bearing = 273; *// Bearing to Los Angeles, CA*

$destination = Point::destination($point, $distance, $bearing);
```

#### Nearest Point

Find the nearest point to a reference point

```php
$referencePoint = new Point(40.7486, -73.9864); *// New York, NY*

$points = [
    new Point(34.0522, -118.2437), *// Los Angeles, CA*
    new Point(41.8781, -87.6298),  *// Chicago, IL*
    new Point(29.7604, -95.3698)   *// Houston, TX*
];

$nearestPoint = Point::nearestPoint($referencePoint, $points);
```

### Polygon

Creates a polygon based on provided vertices as points.

#### Polygon

Creates a new polygon

```php
$vertices = [
    new Point(0, 0),
    new Point(4, 0),
    new Point(4, 3),
    new Point(0, 3)
];

$polygon = new Polygon($vertices);
```

#### Get Vertices

Returns the polygon’s vertices

```php
$vertices = [
    new Point(0, 0),
    new Point(4, 0),
    new Point(4, 3),
    new Point(0, 3)
];

$polygon = new Polygon($vertices);
$vertices = $polygon->getVertices();
```

#### Area

Returns the polygon’s area

```php
$vertices = [
    new Point(0, 0),
    new Point(4, 0),
    new Point(4, 3),
    new Point(0, 3)
];

$polygon = new Polygon($vertices);
$area = $polygon->area();
```

#### Contains Point

Checks to see if a polygon contains a point

```php
$vertices = [
    new Point(0, 0),
    new Point(4, 0),
    new Point(4, 3),
    new Point(0, 3)
];

$polygon = new Polygon($vertices);

$insidePoint = new Point(2, 2);
$outsidePoint = new Point(5, 5);

$isPointInside = $polygon->containsPoint($insidePoint); // TRUE
$isPointInside = $polygon->containsPoint($outsidePoint); // FALSE
```

### LineString

Creates a line based on the provided points.

#### LineString

Creates a new line string

```php
$points = [
    new Point(0, 0),
    new Point(1, 1),
    new Point(2, 2)
];

$lineString = new LineString($points);
```

#### Get Points

Returns the points that create the line string

```php
$points = [
    new Point(0, 0),
    new Point(1, 1),
    new Point(2, 2)
];

$lineString = new LineString($points);
$result = $lineString->getPoints();
```
## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues if you encounter any problems or have suggestions for improvement.

## License

This project is licensed under the GNU AGPLv3 License. See the ~[LICENSE](LICENSE.md)~ file for details.

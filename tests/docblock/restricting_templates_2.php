<?php

declare(strict_types=1);

interface Shape {}

class Square implements Shape {}

class Person {}

/** @template T of Shape */
class ShapeProcessor {}


/** @var ShapeProcessor<Shape> $shapeProcessor */
$shapeProcessor = new ShapeProcessor(); // OK

/** @var ShapeProcessor<Square> $squareProcessor */
$squareProcessor = new ShapeProcessor(); // OK

/** @var ShapeProcessor<Person> $personProcessor */
$personProcessor = new ShapeProcessor(); // ERROR: Person not subtype of Shape

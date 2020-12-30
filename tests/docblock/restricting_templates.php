<?php

declare(strict_types=1);

class Person {}

/**
 * @template T of object
 * @param T $value
 * @return T
 */
function mirror($value)
{
    return $value;
}


$person = mirror(new Person); // OK

$int = mirror(7); // ERROR: int is not an object

$string = mirror("hello"); // ERROR string is not an object

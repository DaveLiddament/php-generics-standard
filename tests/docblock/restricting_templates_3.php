<?php

declare(strict_types=1);


/**
 * @template T of int|string
 * @param T $value
 * @return T
 */
function mirror($value)
{
    return $value;
}


$int = mirror(7); // OK

$string = mirror("hello"); // OK

$bool = mirror(true); // ERROR: Problem as a boolean is not a string or int.

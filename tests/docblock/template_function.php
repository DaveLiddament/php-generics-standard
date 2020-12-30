<?php

declare(strict_types=1);

/**
 * @template T
 * @param T $value
 * @return T
 */
function mirror($value)
{
    return $value;
}

function takesString(string $value): void {}

function takesInt(int $value): void {}


$stringValue = mirror("hello");

takesString($stringValue); // OK

takesInt($stringValue); // ERROR. Method expects int, string given


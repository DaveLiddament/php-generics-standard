<?php

declare(strict_types=1);

namespace Entities;

class Dog {}

class Person {}

/**
 * @template T
 * @param class-string<T> $className
 * @return T
 */
function build(string $className) {
    return new $className;
}

function takesPerson(Person $person): void {}


$person = build(Person::class); // $person is an object of type Person
takesPerson($person); // OK

$dog = build(Dog::class); // $dog is an object of type Dog
takesPerson($dog); // ERROR $dog is not of type Person


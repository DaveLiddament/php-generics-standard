<?php

declare(strict_types=1);

class Person {}


/**
 * @return \Generator<int, string, bool, Person>
 */
function foo(): \Generator
{
    $bool = yield 1 => 'foo';

    return new Person();
}

function takesInt(int $value): void {}
function takesString(string $value): void {}
function takesPerson(Person $person): void {}



foreach (foo() as $key => $value) {
    takesInt($key); // OK
    takesString($value); // OK
    foo()->send(true); // OK


    takesString($key); // ERROR, expects string, given int
    takesInt($value); // ERROR, expects int, given string
    foo()->send("string"); // ERROR, expects bool, given string
}

$person = foo()->getReturn();

takesPerson($person); // OK
takesInt($person); // ERROR: Expects Person, got int.


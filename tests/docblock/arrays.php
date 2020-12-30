<?php

declare(strict_types=1);

class Person {}

function takesInt(int $value): void {}
function takesString(string $value): void {}
function takesArrayKey(string|int $value): void {}
function takesPerson(Person $person): void {}


function takesAnyArray(array $array): void {}

/** @param Person[] $array */
function takesShortSyntaxArray(array $array): void {}

/** @param array<Person> $array */
function takesValueTypeOnlyArray(array $array): void {}

/** @param array<int,Person> $array */
function takesIntKeyAndValueArray(array $array): void {}

/** @param array<string,Person> $array */
function takesStringKeyAndValueArray(array $array): void {}


/** @return Person[] */
function providesShortSyntax()
{
    return [new Person()];
}

$shortSyntaxArray = providesShortSyntax();
takesAnyArray($shortSyntaxArray); // OK
takesValueTypeOnlyArray($shortSyntaxArray); // OK
takesIntKeyAndValueArray($shortSyntaxArray); // ERROR: Array key is not guaranteed int
takesStringKeyAndValueArray($shortSyntaxArray); // ERROR: Array key is not guaranteed string

foreach($shortSyntaxArray as $key => $value) {
    takesPerson($value); // OK
    takesArrayKey($key); // OK
    takesString($key); // ERROR: Array key is not guaranteed int
    takesInt($key); // ERROR: Array key is not guaranteed string
}


/** @return array<Person> */
function providesValueOnly()
{
    return [new Person()];
}

$valueOnlyArray = providesValueOnly();
takesAnyArray($valueOnlyArray); // OK
takesValueTypeOnlyArray($valueOnlyArray); // OK
takesIntKeyAndValueArray($valueOnlyArray); // ERROR: Array key is not guaranteed int
takesStringKeyAndValueArray($valueOnlyArray); // ERROR: Array key is not guaranteed string

foreach($valueOnlyArray as $key => $value) {
    takesPerson($value); // OK
    takesArrayKey($key); // OK
    takesString($key); // ERROR: Array key is not guaranteed int
    takesInt($key); // ERROR: Array key is not guaranteed string
}

/** @return array<int, Person> */
function providesKeyAndValue()
{
    return [new Person()];
}


$keyAndValueArray = providesKeyAndValue();
takesAnyArray($keyAndValueArray); // OK
takesValueTypeOnlyArray($keyAndValueArray); // OK
takesIntKeyAndValueArray($keyAndValueArray); // OK
takesStringKeyAndValueArray($keyAndValueArray); // ERROR: Expects array<string,Person> given array<int,Person>

foreach($keyAndValueArray as $key => $value) {
    takesPerson($value); // OK
    takesArrayKey($key); // OK
    takesString($key); // ERROR: expects string, int given
    takesInt($key); // OK
}

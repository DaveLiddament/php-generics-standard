<?php

declare(strict_types=1);

class Person {}

takesArrayShape(['Anna', 'age' => 21, 'person' => new Person()]); // OK - All data provided
takesArrayShape(['Bob',  'person' => new Person()]); // OK - All all mandatory data provided
takesArrayShape([true, 'age' => 21, 'person' => new Person()]); // ERROR: Wrong type for arg 0.
takesArrayShape(['Charlie', 'age' => 22]); // ERROR: Missing 'Person'
takesArrayShape(['Bob',  'person' => new Person(), 'address' => 'Some street']); // OK - All mandatory data provided, additional fields can also be supplied

/** @param array{0: string, age?:int,  person:Person} $array */
function takesArrayShape(array $array): void {}

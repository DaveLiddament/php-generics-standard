<?php

declare(strict_types=1);

/**
 * @template K
 * @template V
 */
class Map
{
    /** @var array<K,V> */
    private $values = [];

    /**
     * @param K $key of array-key
     * @param V $value
     */
    public function add($key, $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * @param K $key
     * @return  V
     */
    public function getValue($key)
    {
        if (array_key_exists($key, $this->values)) {
            return $this->values[$key];
        }
        throw new InvalidArgumentException("Key not found");
    }
}

class Person {}
function takesString(string $value): void {}
function takesPerson(Person $value): void {}


/** @var Map<string,Person> $people */
$people = new Map(); // OK

$people->add("Anna", new Person()); // OK
$people->add(1, new Person()); // ERROR. Argument 1 expected string, got int


$person = $people->getValue('Anna');

takesPerson($person); // OK
takesString($person); // ERROR, Expects string, got Person

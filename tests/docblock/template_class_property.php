<?php

declare(strict_types=1);

/**
 * @template T
 */
class ValueHolder
{
    /** @var T */
    private $value;

    /** @param T $value */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /** @return T */
    public function value()
    {
        return $this->value;
    }
}


function takesInt(int $int): void {}

function takesString(string $string): void {}



class Entity {

    /** @var ValueHolder<int>  */
    public ValueHolder $ageValueHolder;

    public function __construct()
    {
        $this->ageValueHolder = new ValueHolder(24);
    }
}

$entity = new Entity();

takesInt($entity->ageValueHolder->value()); // OK
takesString($entity->ageValueHolder->value()); // ERROR. Passing int, expects string.


$entity->ageValueHolder = new ValueHolder(33); // OK
$entity->ageValueHolder = new ValueHolder("hello"); // ERROR. Assigning ValueHolder<string> to property that should be ValueHolder<int>


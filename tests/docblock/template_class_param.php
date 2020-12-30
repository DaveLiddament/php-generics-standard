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

/** @param  ValueHolder<int> $valueHolder */
function takesIntValueHolder(ValueHolder $valueHolder): void
{
    takesInt($valueHolder->value()); // OK
    takesString($valueHolder->value()); // ERROR. Passing int to a function expecting string.
}

takesIntValueHolder(new ValueHolder(20)); // OK
takesIntValueHolder(new ValueHolder("hello")); // ERROR. Passing ValueHolder<string>, expected ValueHolder<int>



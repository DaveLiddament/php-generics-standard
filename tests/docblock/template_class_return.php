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

/** @return ValueHolder<int> */
function givesIntValueHolder(): ValueHolder
{
    return new ValueHolder(23);
}

$ageValueHolder = givesIntValueHolder();


takesInt($ageValueHolder->value()); // OK

takesString($ageValueHolder->value()); // ERROR. Passing int to a function expecting string.


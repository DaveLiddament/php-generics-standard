<?php

declare(strict_types=1);

/**
 * @template T
 */
class Queue
{
    /** @var T[] */
    private $values = [];

    /** @param T $item */
    public function add($item): void
    {
        $this->values[] = $item;
    }

    /** @return T */
    public function next()
    {
        $value = array_shift($this->values);
        if ($value === null) {
            throw new LogicException("Queue is empty");
        }
        return $value;
    }
}


/** @var Queue<string> $stringQueue */
$stringQueue = new Queue(); // OK

$intQueue = new Queue(); // ERROR. Unknown type for Queue


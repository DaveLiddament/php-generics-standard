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


/**
 * @param Queue<int> $queue
 */
function takesIntQueue(Queue $queue): void {}

/*
 * The type of Queue must be known at the time it is used.
 * It would not be reasonable to infer type of Queue based on the fact it is eventually passed to a function that
 * specifies the type of the Queue.
 */
$intQueue = new Queue(); // ERROR. Unknown type for Queue
$intQueue->add(1);
takesIntQueue($intQueue); // ERROR. Expects Queue<int>, given Queue

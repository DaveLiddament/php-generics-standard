<?php

class Person
{
}

interface Job
{
}


/** @template T of Job */
interface JobProcessor
{
    /** @return class-string<T> */
    public function supports(): string;

    /** @param T $job */
    public function process($job): void;
}


/** @implements JobProcessor<Person> */
class PersonProcessor implements JobProcessor // ERROR. Person does not extend Job
{
    public function supports(): string // OPTIONAL. Expecting class-string<Job> got string. Given issue is with the whole class it doesn't matter if SA picks this up or not.
    {
        return Person::class;
    }

    public function process($job): void
    {
        // Not really valid
    }
}

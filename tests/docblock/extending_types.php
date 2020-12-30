<?php

class Animal {}

class Person {}

/** @template T */
abstract class Repository
{
    /** @param T $entity */
    public function persist($entity): void {}
}

/** @extends Repository<Person> */
class PersonRepository extends Repository
{
}

$personRepository = new PersonRepository();

$personRepository->persist(new Person()); // OK
$personRepository->persist(new Animal()); // ERROR. Expecting Person, got Animal

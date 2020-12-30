<?php

// See examples of problems in
// Psalm: https://psalm.dev/r/ecc3bf7a6a
// PHPStan: https://phpstan.org/r/d9511997-e344-40a7-9d97-625eae1a1c80

interface Animal {}

class Dog implements Animal
{
    public function bark(): void {}
}

class Cat implements Animal {}

/**
 * @template T of Animal
 */
interface AnimalGame
{
    /** @param T $animal */
    public function play(
        $animal,
    ): void;
}

/**
 * @implements AnimalGame<Dog>
 */
class DogGame implements AnimalGame
{
    public function play($animal): void
    {
        $animal->bark();
    }
}

// Given
$dog = new Dog();
$cat = new Cat();
$dogGame = new DogGame();


// This is correct
$dogGame->play($dog);

// ERROR: This should be picked up as an error by static analysis
$dogGame->play($cat);


interface Car {}

// ERROR: This should also be picked up as an error by static analysis
/** @implements AnimalGame<Car> */
class CarGame implements AnimalGame
{
    public function play($animal): void {}
}

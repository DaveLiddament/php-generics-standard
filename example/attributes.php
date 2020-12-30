<?php

require_once __DIR__ . "/../vendor/autoload.php";

use StaticAnalysis\Generics\v1\Implement;
use StaticAnalysis\Generics\v1\Template;
use StaticAnalysis\Generics\v1\Type;


interface Animal {}

class Dog implements Animal {
    public function bark(): void {}
}

class Cat implements Animal {}

#[Template('T', Animal::class)]
interface AnimalGame {
    public function play(
        #[Type('T')] $animal,
    ): void;
}

#[Implement("AnimalGame<Dog>")]
class DogGame implements AnimalGame {

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
$cat = new Cat();
$dogGame = new DogGame();


// This is correct
$dogGame->play($dog);

// This should be picked up as an error by static analysis
$dogGame->play($cat);


interface Car {}

// This should also be picked up as an error by static analysis
#[Implement("AnimalGame<Car>")]
class CarGame implements AnimalGame
{
    public function play($animal): void {}
}


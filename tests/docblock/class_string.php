<?php

declare(strict_types=1);

namespace Entities;

class Person {}

/**
 * @param class-string $className
 */
function takesClassString(string $className): void {}

takesClassString(Person::class); // OK

takesClassString('Entities\Person'); // OK

takesClassString("a random string"); // ERROR: Does not represent FQCN

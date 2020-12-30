<?php

declare(strict_types=1);

/**
 * @return \Generator<int, string>
 */
function foo(): \Generator
{
    yield 1 => 'foo';
}

function takesInt(int $value): void
{
}

function takesString(string $value): void
{
}


foreach (foo() as $key => $value) {
    takesInt($key); // OK
    takesString($value); // OK

    takesString($key); // ERROR, expects string, given int
    takesInt($value); // ERROR, expects int, given string
}


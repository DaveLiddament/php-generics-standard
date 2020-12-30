<?php

declare(strict_types=1);

/*
 * This works in Psalm, but not in PHPStan.
 *
 * PHPStan complains that return type of `mixed` is not a subtype of `object`.
 * The fact `T` must represent a class-string implies that `T` must be a subtype of `object`.
 *
 * Question: As part of this standard should this level of implication be required, or should it be explicit as in `build2`
 */

/**
 * @template T
 * @param class-string<T> $className
 * @return T
 */
function build(string $className): object {
    return new $className;
}



/*
 * Explicit version. Satisfies both PHPStan and Psalm.
 */

/**
 * @template T of object
 * @param class-string<T> $className
 * @return T
 */
function build2(string $className): object {
    return new $className;
}

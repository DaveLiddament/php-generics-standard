<?php

declare(strict_types=1);


namespace StaticAnalysis\Generics\v1;


use Attribute;


#[Attribute(Attribute::TARGET_CLASS)]
class Implement
{
    public function __construct(
        public string $type,
    ) {}
}

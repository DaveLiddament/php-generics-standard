<?php

declare(strict_types=1);


namespace StaticAnalysis\Generics\v1;


use Attribute;


#[Attribute(Attribute::TARGET_FUNCTION|Attribute::TARGET_METHOD|Attribute::TARGET_PARAMETER|Attribute::TARGET_PROPERTY)]
class Type
{
    public function __construct(
        public string $type,
    ) {}
}

<?php

declare(strict_types=1);


namespace StaticAnalysis\Generics\v1;


use Attribute;


#[Attribute(Attribute::TARGET_CLASS|Attribute::TARGET_FUNCTION|Attribute::TARGET_METHOD|Attribute::IS_REPEATABLE)]
class Template
{
    public function __construct(
        public string $name,
        public ?string $of = null,
    ) {}
}

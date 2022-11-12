<?php

namespace AhmetBarut\Documentor\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD | Attribute::TARGET_PROPERTY)]
class Document
{
    public function __construct(
        public string $description,
    ) {
    }
}

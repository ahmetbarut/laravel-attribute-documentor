<?php

namespace AhmetBarut\Documentor\Tests\Support;

use AhmetBarut\Documentor\Attributes\Document;

#[Document(description: 'TestClass')]
class TestClass
{
    #[Document(description: 'testProperty')]
    public $testProperty;

    #[Document(description: "testMethod")]
    public function testMethod()
    {
        return;
    }
}

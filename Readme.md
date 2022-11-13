# laravel documentor

It provides you the api for the document using the attributes.

## Example

```php
<?php

namespace Tests;

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
```

```shell
[
    "class" => array:1 [
      0 => "TestClass"
    ]
    "methods" => array:1 [
      "testMethod" => array:1 [
        0 => "testMethod"
      ]
    ]
    "properties" => array:1 [
      "testProperty" => array:1 [
        0 => "testProperty"
      ]
    ]
]
```

## Test

```shell
composer test
```

## Installation

You can install the package via composer:

```bash
composer require ahmetbarut/laravel-attributes-documentor
```

## Usage

```php
use AhmetBarut\Documentor\FindAttributeDescription;

$documentor = new FindAttributeDescription([
  ...paths
]);

$documentor->find();

$documentor
// only class
->getClassAttributeDescription()

// only methods
->getMethodsDescription()

// only properties
->getPropertiesDescription()
// filter null values
->filter()

```

## Write To Markdown

```php
use AhmetBarut\Documentor\FindAttributeDescription;
use AhmetBarut\Documentor\Templates\Markdown;

$documentor = new FindAttributeDescription([
  ...paths
]);

$documentor->find();

$data = $documentor->getClassAttributeDescription()->getMethodsDescription()->getPropertiesDescription()->filter();

$markdown = new Markdown();

// default path is docs
$markdown->write($data);
```

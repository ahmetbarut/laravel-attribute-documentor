<?php

use AhmetBarut\Documentor\FindAttributeDescription;
use AhmetBarut\Documentor\Templates\Markdown;

$attributesFinder = new FindAttributeDescription([
    __DIR__ . '/Support',
]);

$attributesFinder->find();

$attributesFinder
    ->getClassAttributeDescription()
    ->getMethodsDescription()
    ->getPropertiesDescription();

$markdown = new class extends Markdown
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/temp', 'docs.md');
    }
};

$markdown->write($attributesFinder->filter());

test('test has markdown file', function () {
    expect(file_exists(__DIR__ . '/temp/docs.md'))->toBeTrue();
});

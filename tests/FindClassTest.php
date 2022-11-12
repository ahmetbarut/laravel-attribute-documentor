<?php

use AhmetBarut\Documentor\FindAttributeDescription;
use Illuminate\Support\Arr;

$attributesFinder = new FindAttributeDescription([
    __DIR__ . '/Support',
]);

test('test get classes', function () use (&$attributesFinder) {
    $attributesFinder->find();

    expect($attributesFinder->getClasses())->toBeArray();

    expect($attributesFinder->getClasses())->toHaveCount(1);
});

test('test classes have arrays count', function () use (&$attributesFinder) {
    $attributesFinder->getClassAttributeDescription();

    expect(Arr::first($attributesFinder->getAttributes())['class'])->toHaveCount(1);
});


test('test properties have arrays count', function () use (&$attributesFinder) {
    $attributesFinder->getPropertiesDescription();

    expect(Arr::first(
        $attributesFinder->getAttributes()
    )['properties'])->toHaveCount(1);
});

test('test get methods description', function () use (&$attributesFinder) {
    $attributesFinder->getMethodsDescription();

    expect(Arr::first(
        $attributesFinder->getAttributes()
    )['methods'])->toHaveCount(1);
});

<?php

namespace AhmetBarut\Documentor\Templates;

use AhmetBarut\Documentor\Contracts\Writer;

class Markdown
{
    public function __construct(protected string $path, protected string $fileName)
    {
    }
    
    public function getPath(): string
    {
        return $this->path;
    }

    public function write(array $attributes): bool
    {
        $content = $this->generate($attributes);

        return file_put_contents($this->getPath() . '/' . $this->fileName, $content);
    }

    private function generate(array $attributes): string
    {
        $content = '';
        foreach ($attributes as $className => $attribute) {
            $content .= $this->generateClass($attribute, $className);
        }
        return $content;
    }

    private function generateClass(array $attribute, string $className): string
    {
        $content = '## ' . $className . PHP_EOL;
        $content .= $this->generateClassDescription($attribute);
        $content .= PHP_EOL . $this->generateClassMethods($attribute);
        $content .= PHP_EOL . $this->generateClassProperties($attribute);

        return $content;
    }

    private function generateClassDescription(array $attribute): string
    {
        $content = '';

        foreach ($attribute['class'] as $key => $description) {
            $content .= ($key + 1) . '. ' . $description . PHP_EOL;
        }

        return $content;
    }

    private function generateClassProperties(array $attribute): string
    {
        $content = '';

        if (isset($attribute['properties'])) {
            foreach ($attribute['properties'] as $property => $description) {
                $content .= '## Properties' . PHP_EOL;
                $content .= '### $' . $property . PHP_EOL;
                $content .= $this->generateProperty($description);
            }
        }

        return $content;
    }

    private function generateProperty(array $descriptions): string
    {
        $content = '';
        foreach ($descriptions as $key => $description) {
            $content .= ($key + 1) . '. ' . $description . PHP_EOL;
        }

        return $content;
    }

    private function generateClassMethods(array $attribute): string
    {
        $content = '';

        if (isset($attribute['methods'])) {
            $content .= '## Methods' . PHP_EOL;

            foreach ($attribute['methods'] as $method => $description) {
                $content .= '### ' . $method .'()'. PHP_EOL;
                $content .= $this->generateMethod($description);
            }
        }

        return $content;
    }

    private function generateMethod(array $method): string
    {
        $content = '';

        foreach ($method as $key => $description) {
            $content .= ($key + 1) . '. ' . $description . PHP_EOL;
        }

        return $content;
    }
}

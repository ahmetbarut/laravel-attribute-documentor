<?php

namespace AhmetBarut\Documentor;

use AhmetBarut\Documentor\Attributes\Document;
use AhmetBarut\Documentor\Contracts\Writer;
use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Str;
use Reflector;

class FindAttributeDescription
{
    /**
     * Collects classes with Attribute here
     * @var array<int, string>
     */
    protected array $classes = [];

    /**
     * It stores information collected from attributes here. It contains descriptions of the class, properties, and methods.
     * @var array<string, string>
     */
    protected array $attributes = [];

    /**
     * @var iterable $paths
     */
    public function __construct(
        public iterable $paths,
    ) {
        # code...
    }

    /**
     * First, he needs to collect the classes. It then prepares them for use.
     * @return static
     */
    public function find(): static
    {
        $finder = new Finder();

        $files = $finder->files()
            ->in($this->paths)
            ->name('*.php');

        foreach ($files as $file) {
            $this->classes[] = $this->getNamespace($file->getContents(), $file->getFilename());
        }
        return $this;
    }

    /**
     * Returns the field name of the class.
     * @return string
     */
    protected function getNamespace(string $classPath, string $fileName): string
    {
        return Str::of($classPath)->match('/namespace (.*);/m')
            ->append('\\')
            ->append(Str::of($fileName)->replace('.php', ''))
            ->__toString();
    }

    /**
     * It collects the information from the attributes and returns it.
     * @return array<string, string>
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * If the class does not have attributes, it omits the class.
     */
    public function getDocumentedClasses(): array
    {
        return array_filter(
            $this->classes,
            fn ($class) => class_exists($class)
        );
    }

    /**
     * Returns the description of the class.
     * @return static
     */
    public function getClassAttributeDescription(): static
    {
        $classes = $this->getDocumentedClasses();

        $this->attributes = [];

        foreach ($classes as $class) {
            $this->attributes[$class] = [
                'class' => $this->getAttributesDescription(new ReflectionClass($class)),
                'methods' => [],
                'properties' => [],
            ];
        }

        return $this;
    }

    /**
     * Returns the description of the methods.
     * @return static
     */
    public function getMethodsDescription(): static
    {
        foreach ($this->attributes as $class => $methods) {
            $reflectionMethod = new ReflectionClass($class);
            foreach ($reflectionMethod->getMethods() as $method) {
                $attributes = $this->getAttributesDescription($method);
                if (count($attributes) > 0) {
                    $this->attributes[$class]['methods'][$method->getName()] = $attributes;
                }
            }
        }

        return $this;
    }

    /**
     * Returns the description of the properties.
     * @return static
     */
    public function getPropertiesDescription(): static
    {
        foreach ($this->attributes as $class => $methods) {
            $reflectionMethod = new ReflectionClass($class);
            foreach ($reflectionMethod->getProperties() as $property) {
                $attributes = $this->getAttributesDescription($property);
                if (count($attributes) > 0) {
                    $this->attributes[$class]['properties'][$property->getName()] = $attributes;
                }
            }
        }

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    protected function getAttributesDescription(Reflector $reflection): array
    {
        return array_map(
            fn ($attribute) => $attribute->getArguments()['description'],
            $reflection->getAttributes(Document::class)
        );
    }

    public function filter(): array
    {
        return array_filter(
            $this->attributes,
            fn ($attribute) => count($attribute['methods']) > 0 ||
                count($attribute['properties']) > 0 ||
                count($attribute['class']) > 0
        );
    }

    public function write(Writer $writer)
    {
        dd($writer);
    }
}

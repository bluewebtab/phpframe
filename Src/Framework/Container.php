<?php

declare(strict_types=1);


namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\ContainerException;


class Container
{
    private array $definitions = [];
    private array $resolved = [];
    public function addDefinitions(array $newDefinitions)
    {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }


    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);


        //abstract classes is one example of classes that can't be instantiated
        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$className} is not instantiable");
        }

        //If a class doesn't have dependencies, there isn't a reason to define the construct method before moving
        //We should then verify if the class has a construct method
        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $className;
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];


        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            //checks for type hinting
            if (!$type) {
                throw new ContainerException("Failed to resolve class {$className} because param {$name} is missing a type hint.");
            }

            //checks param 
            //Class A parameter has the reflectionNamedType when there is only one type.
            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Failed to resolve class {$className} because invalid param name.");
            }

            $dependencies[] = $this->get($type->getName());
        }




        return $reflectionClass->newInstanceArgs($dependencies);
    }


    //The get method is going to return an instance of any dependency
    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class {$id} does not exist in container.");
        }


        if (array_key_exists($id, $this->resolved)) {

            return $this->resolved[$id];
        }

        $factory = $this->definitions[$id];
        $dependency = $factory($this);

        $this->resolved[$id] = $dependency;


        return $dependency;
    }
}

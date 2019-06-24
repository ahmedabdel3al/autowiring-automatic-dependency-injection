<?php
namespace App\Container;

use App\Execption\NotFoundExcpetion;


class Container
{
    /**
     * dependancies should loaded with request
     *
     * @var array
     */
    protected $dependancies = [];

    /**
     * set item inside container
     *
     * @param [type] $name
     * @param callable $closure
     * @return void
     */
    public function set($name, callable $closure)
    {
        $this->dependancies[$name] = $closure;
    }
    /**
     * set item inside container if not resolved before
     *
     * @param [type] $name
     * @param callable $closure
     * @return object
     */
    public function singleTon($name, callable $closure)
    {
        $this->dependancies[$name] = function () use ($closure) {
            static $resolved;
            if (!$resolved) {
                $resolved = $closure($this);
            }
            return $resolved;
        };
    }
    /**
     * Check if Container Has dependance name
     *
     * @param [type] $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->dependancies[$name]);
    }
    /**
     * Resolve dependances
     *
     * @param [type] $name
     * @return void
     */
    public function get($name)
    {
        if ($this->has($name)) {
            return $this->dependancies[$name]($this);
        }
        return  $this->autowire($name);
    }
    public function autowire($name)
    {
        if (!class_exists($name)) {
            throw new NotFoundExcpetion;
        }
        $reflector = $this->getReflector($name);
        if (!$reflector->isInstantiable()) {
            throw new NotFoundExcpetion;
        }
        if ($constactor = $reflector->getConstructor()) {
            $dependances = $this->getConstructorDependances($constactor);
           return  $reflector->newInstanceArgs($dependances);
        
        }
        return new $name();
    }

    protected function getConstructorDependances($constactor)
    {
        return array_map(function ($dependacy) {
           return  $this->resolve($dependacy);
        }, $constactor->getParameters());
    }

    protected function resolve($dependacy)
    { 
        if(is_null($dependacy->getClass())){
            throw new NotFoundExcpetion  ;
        }
       return  $this->get($dependacy->getClass()->getName());

    }
    /**
     *  Resolve dependances By Calling get Method
     *
     * @param [type] $name
     * @return void
     */
    public function __get($name)
    {
        return $this->get($name);
    }
    public function getReflector($class)
    {
        return new \ReflectionClass($class);
    }
}

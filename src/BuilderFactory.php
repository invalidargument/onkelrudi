<?php

namespace RudiBieller\OnkelRudi;

class BuilderFactory implements BuilderFactoryInterface
{
    private $_instances;

    public function create($name)
    {
        if (!class_exists($name)) {
            throw new \InvalidArgumentException('No matching builder found for argument ' . $name);
        }

        if (isset($this->_instances[$name])) {
            return $this->_instances[$name];
        }

        $this->_instances[$name] = new $name();

        return $this->_instances[$name];
    }
}
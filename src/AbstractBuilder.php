<?php

namespace RudiBieller\OnkelRudi;

abstract class AbstractBuilder
{
    protected $properties = array();

    abstract public function build();

    public function reset()
    {
        $this->properties = array();
    }
}

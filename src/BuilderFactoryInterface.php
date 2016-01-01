<?php

namespace RudiBieller\OnkelRudi;

interface BuilderFactoryInterface
{
    /**
     * @param $name
     * @return BuilderInterface
     */
    public function create($name);
}

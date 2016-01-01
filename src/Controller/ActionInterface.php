<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\BuilderFactoryInterface;
use RudiBieller\OnkelRudi\ServiceInterface;

interface ActionInterface
{
    public function setApp(\Slim\App $app);

    public function setService(ServiceInterface $service);

    public function setBuilderFactory(BuilderFactoryInterface $factory);
}

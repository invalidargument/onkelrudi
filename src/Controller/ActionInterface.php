<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\ServiceInterface;

interface ActionInterface
{
    public function setApp(\Slim\App $app);

    public function setService(ServiceInterface $service);
}
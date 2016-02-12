<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Wordpress\ServiceInterface;

interface HttpActionInterface
{
    public function setWordpressService(ServiceInterface $service);
}

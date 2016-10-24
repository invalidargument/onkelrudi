<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Ical\ServiceInterface;

interface IcalActionInterface
{
    public function setIcalService(ServiceInterface $service);
}

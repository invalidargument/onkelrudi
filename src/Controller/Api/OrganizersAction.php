<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;

class OrganizersAction extends AbstractJsonAction
{
    protected function getData()
    {
        return $this->organizerService->getAllOrganizers();
    }
}

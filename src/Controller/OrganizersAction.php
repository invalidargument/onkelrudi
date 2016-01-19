<?php

namespace RudiBieller\OnkelRudi\Controller;

class OrganizersAction extends AbstractJsonAction
{
    protected function getData()
    {
        return $this->organizerService->getAllOrganizers();
    }
}

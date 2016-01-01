<?php

namespace RudiBieller\OnkelRudi\Controller;

class OrganizersAction extends AbstractAction
{
    protected function getData()
    {
        return $this->service->getAllOrganizers();
    }
}

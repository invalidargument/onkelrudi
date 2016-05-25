<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;

class OrganizerAction extends AbstractJsonAction
{
    protected function getData()
    {
        // TODO: if not found, return 404
        return $this->organizerService->getOrganizer($this->args['id']);
    }
}

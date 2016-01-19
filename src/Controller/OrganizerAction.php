<?php

namespace RudiBieller\OnkelRudi\Controller;

class OrganizerAction extends AbstractJsonAction
{
    protected function getData()
    {
        // TODO: if not found, return 404
        return $this->organizerService->getOrganizer($this->args['id']);
    }
}

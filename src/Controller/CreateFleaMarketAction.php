<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\OrganizerService;
use RudiBieller\OnkelRudi\User\Organizer;

class CreateFleaMarketAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'createFleaMarket.html';

    protected function getData()
    {
        $fleamarketOrganizers = [];

        foreach ($this->organizerService->getAllOrganizers() as $organizer) {
            $fleamarketOrganizers[] = ['id' => $organizer->getId(), 'name' => $organizer->getName()];
        }

        $isOrganizer = false;
        $organizerId = null;
        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        if ($user instanceof Organizer) {
            $isOrganizer = true;
            $organizerId = $this->userService->getOrganizerIdByUserId($user->getIdentifier());
        }

        $this->templateVariables['isTest'] = $this->isTestRequest;
        $this->templateVariables['loggedIn'] = true;
        $this->templateVariables['fleamarket_organizers'] = $fleamarketOrganizers;
        $this->templateVariables['createForm'] = true;
        $this->templateVariables['isOrganizer'] = $isOrganizer;
        $this->templateVariables['defaultOrganizerId'] = OrganizerService::DEFAULT_ORGANIZER;
        $this->templateVariables['actualOrganizerId'] = $organizerId;

        return $fleamarketOrganizers;
    }
}

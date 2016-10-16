<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\User\Organizer;

class EditFleaMarketAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'createFleaMarket.html';

    protected function getData()
    {
        $fleamarketId = $this->args['id'];
        $fleamarket = $this->service->getFleaMarket($fleamarketId);

        $organizer = null;
        $user = $this->userService->getAuthenticationService()->getStorage()->read();
        if ($user instanceof Organizer) {
            $organizer = $this->organizerService->getOrganizerByUserId($user->getIdentifier());
        }

        $this->templateVariables['isTest'] = $this->isTestRequest;
        $this->templateVariables['loggedIn'] = true;
        $this->templateVariables['fleamarket_organizers'] = [];
        $this->templateVariables['editForm'] = true;
        $this->templateVariables['editDto'] = $fleamarket;
        $this->templateVariables['organizer'] = $organizer;
        return [];
    }
}

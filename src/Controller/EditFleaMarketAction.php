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
        $fleamarket->setOrganizer(
            $this->organizerService->getOrganizer($fleamarket->getOrganizer()->getId())
        );

        $isOrganizer = false;
        $user = $this->userService->getAuthenticationService()->getStorage()->read();

        if ($user instanceof Organizer) {
            $isOrganizer = true;
        }

        $this->templateVariables['isTest'] = $this->isTestRequest;
        $this->templateVariables['loggedIn'] = true;
        $this->templateVariables['fleamarket_organizers'] = [];
        $this->templateVariables['editForm'] = true;
        $this->templateVariables['editDto'] = $fleamarket;
        $this->templateVariables['isOrganizer'] = $isOrganizer;
        return [];
    }
}

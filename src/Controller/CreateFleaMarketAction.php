<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Config\Config;

class CreateFleaMarketAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'createFleaMarket.html';

    protected function getData()
    {
        $fleamarketOrganizers = [];

        foreach ($this->organizerService->getAllOrganizers() as $organizer) {
            $fleamarketOrganizers[] = ['id' => $organizer->getId(), 'name' => $organizer->getName()];
        }

        $this->templateVariables['isTest'] = $this->isTestRequest;
        $this->templateVariables['loggedIn'] = true;
        $this->templateVariables['fleamarket_organizers'] = $fleamarketOrganizers;

        return $fleamarketOrganizers;
    }
}
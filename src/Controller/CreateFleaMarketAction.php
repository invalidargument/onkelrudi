<?php

namespace RudiBieller\OnkelRudi\Controller;

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
        $this->templateVariables['createForm'] = true;

        return $fleamarketOrganizers;
    }
}

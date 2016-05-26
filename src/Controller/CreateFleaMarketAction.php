<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Config\Config;

class CreateFleaMarketAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'createFleaMarket.html';

    protected function getData()
    {
        $isTest = (new Config())->getSystemConfiguration()['environment'] === 'dev' &&
            strpos($this->request->getUri()->getQuery(), 'test=1') !== false;

        if (!$isTest && is_null($this->userService->getAuthenticationService()->getStorage()->read())) {
            $this->templateVariables['notLoggedIn'] = true;
            return array();
        }

        $fleamarketOrganizers = [];

        foreach ($this->organizerService->getAllOrganizers() as $organizer) {
            $fleamarketOrganizers[] = ['id' => $organizer->getId(), 'name' => $organizer->getName()];
        }

        $this->templateVariables['isTest'] = $isTest;
        $this->templateVariables['loggedIn'] = true;
        $this->templateVariables['fleamarket_organizers'] = $fleamarketOrganizers;

        return $fleamarketOrganizers;
    }
}
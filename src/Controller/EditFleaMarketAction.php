<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarketInterface;

class EditFleaMarketAction extends AbstractHttpAction implements UserAwareInterface
{
    protected $template = 'createFleaMarket.html';

    protected function getData()
    {
        $fleamarketId = $this->args['id'];
        $fleamarket = $this->service->getFleaMarket($fleamarketId);

        $this->templateVariables['isTest'] = $this->isTestRequest;
        $this->templateVariables['loggedIn'] = true;
        $this->templateVariables['fleamarket_organizers'] = [];
        $this->templateVariables['editForm'] = true;
        $this->templateVariables['editDto'] = $fleamarket;
        return [];
    }
}

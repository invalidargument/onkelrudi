<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketDetailAction extends AbstractHttpAction
{
    protected $template = 'fleaMarketDate.html';

    protected function getData()
    {
        $fleaMarket = $this->service->getFleaMarket($this->args['id']);

        if (is_null($fleaMarket)) {
            return null;
        }

        $fleaMarket->setOrganizer(
            $this->organizerService->getOrganizer($fleaMarket->getOrganizer()->getId())
        );

        return $fleaMarket;
    }
}

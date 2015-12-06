<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketAction extends AbstractAction
{
    protected function getData()
    {
        return $this->service->getFleaMarket($this->args['id']);
    }
}
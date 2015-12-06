<?php

namespace RudiBieller\OnkelRudi\Controller;

class FleaMarketsAction extends AbstractAction
{
    protected function getData()
    {
        return $this->service->getAllFleaMarkets();
    }
}
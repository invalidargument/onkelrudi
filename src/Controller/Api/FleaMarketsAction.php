<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;

class FleaMarketsAction extends AbstractJsonAction
{
    protected function getData()
    {
        return $this->service->getAllFleaMarkets();
    }
}

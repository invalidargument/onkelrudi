<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class FleaMarketDetailAction extends AbstractHttpAction
{
    protected $template = 'fleaMarketDate.html';

    protected function getData()
    {
        $fleaMarket = $this->service->getFleaMarket($this->args['id']);

        $this->_setDateInfoTemplateVariables($fleaMarket);

        if (is_null($fleaMarket)) {
            return null;
        }

        $fleaMarket->setOrganizer(
            $this->organizerService->getOrganizer($fleaMarket->getOrganizer()->getId())
        );

        return $fleaMarket;
    }

    public function _setDateInfoTemplateVariables(FleaMarket $market)
    {
        $hasValidDate = false;
        $nextValidDateStart = $nextValidDateEnd = null;
        $today = date('Y-m-d 00:00:00');

        foreach ($market->getDates() as $date) {
            if (strtotime($date->getStart()) >= strtotime($today)) {
                $hasValidDate = true;
                $nextValidDateStart = $date->getStart();
                $nextValidDateEnd = $date->getEnd();
                break;
            }
        }

        $this->templateVariables['hasValidDate'] = $hasValidDate;
        $this->templateVariables['nextValidDateStart'] = $nextValidDateStart;
        $this->templateVariables['nextValidDateStartEnd'] = $nextValidDateEnd;
    }
}

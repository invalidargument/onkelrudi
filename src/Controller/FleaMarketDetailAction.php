<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\FleaMarket\FleaMarket;

class FleaMarketDetailAction extends AbstractHttpAction
{
    protected $template = 'fleaMarketDate.html';

    protected function getData()
    {
        $fleaMarket = $this->service->getFleaMarket($this->args['id']);

        if (is_null($fleaMarket)) {
            return null;
        }

        $this->_setDateInfoTemplateVariables($fleaMarket);

        $fleaMarket->setOrganizer(
            $this->organizerService->getOrganizer($fleaMarket->getOrganizer()->getId())
        );

        $currentUrl = $this->app->getContainer()->router->pathFor('event-date', [
            'wildcard' => $fleaMarket->getSlug(),
            'id' => $fleaMarket->getId()
        ]);
        $this->templateVariables['currentUrl'] = $currentUrl;

        return $fleaMarket;
    }

    public function _setDateInfoTemplateVariables(FleaMarket $market)
    {
        $hasValidDate = false;
        $nextValidDateStart = $nextValidDateEnd = null;

        $comparisonDate = date('Y-m-d 00:00:00');
        $dates = $market->getDates();

        foreach ($dates as $date) {
            if (strtotime($date->getStart()) >= strtotime($comparisonDate)) {
                $hasValidDate = true;
                $nextValidDateStart = $date->getStart();
                $nextValidDateEnd = $date->getEnd();
                break;
            }
        }

        $this->templateVariables['hasValidDate'] = $hasValidDate;
        $this->templateVariables['nextValidDateStart'] = $nextValidDateStart;
        $this->templateVariables['nextValidDateEnd'] = $nextValidDateEnd;

        if (!$hasValidDate) {
            // yes, assuming every fleamarket has at least a date.
            $lastDate = $dates[count($dates) -1];
            $this->templateVariables['nextValidDateStart'] = $lastDate->getStart();
            $this->templateVariables['nextValidDateEnd'] = $lastDate->getEnd();
        }
    }
}

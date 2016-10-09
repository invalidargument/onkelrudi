<?php

namespace RudiBieller\OnkelRudi\Controller;

class IndexAction extends AbstractHttpAction
{
    protected $template = 'index.html';

    protected function getData()
    {
        $start = null;
        $month = $this->args['month'];

        if (!is_null($month)) {
            list($m, $y) = explode('-', $month);
            $start = new \DateTimeImmutable($y . '-' . $m . '-01 00:00:01');
        }

        $zip = $this->args['zip'];

        $isTest = strpos($this->request->getUri()->getQuery(), 'test=1') !== false;
        $fleaMarkets = $this->service->getAllFleaMarketsByTimespan($start);
        $wpCategories = $this->wordpressService->getAllCategories();
        $dates = $this->service->getAllUpcomingDates();
        $marketsDetailRoutes = [];
        $zipAreaRange = [];
        $monthRange = [];
        foreach ($dates as $dateItem) {
            $monthRange[date('m-Y', strtotime($dateItem->getStart()))] = date('m/Y', strtotime($dateItem->getStart()));
        }
        foreach ($fleaMarkets as $fleaMarket) {
            $marketsDetailRoutes[$fleaMarket->getId()] = $this->app->getContainer()->router->pathFor('event-date', [
                'wildcard' => $fleaMarket->getSlug(),
                'id' => $fleaMarket->getId()
            ]);

            $zipCode = $fleaMarket->getZipCode();
            if (!is_null($zipCode)) {
                $zipArea = (int) substr($fleaMarket->getZipCode(), 0, 1);
                $zipAreaRange[$zipArea] = $zipArea;
            }
        }
        sort($zipAreaRange);

        $this->templateVariables['fleamarkets'] = $fleaMarkets;
        $this->templateVariables['fleamarketsDetailsRoutes'] = $marketsDetailRoutes;
        $this->templateVariables['wpCategories'] = $wpCategories;
        $this->templateVariables['monthRange'] = $monthRange;
        $this->templateVariables['zipAreaRange'] = $zipAreaRange;
        $this->templateVariables['selectedMonth'] = str_replace('-', '/', $month);
        $this->templateVariables['selectedZipAreaRange'] = $this->_getSelectedZipRange($zip);
        $this->templateVariables['isLoggedIn'] = $this->userService->isLoggedIn();
        $this->templateVariables['isTest'] = (boolean)$isTest;

        //var_dump($this->templateVariables);die;

        return array();
    }

    private function _getSelectedZipRange($zip)
    {
        if ($zip == 'alle') {
            return 'alle';
        }

        return substr($zip, 0, 1);
    }
}

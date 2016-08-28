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
            list($m, $y) = explode('/', $month);
            $start = new \DateTimeImmutable($y . '-' . $m . '-01 00:00:01');
        }

        $zip = $this->args['zip'];

        $isTest = strpos($this->request->getUri()->getQuery(), 'test=1') !== false;
        $fleaMarkets = $this->service->getAllFleaMarketsByTimespan($start);
        $wpCategories = $this->wordpressService->getAllCategories();
        //$dates = $service->getAllUpcomingDates();
        $fleaMarketsDetailRoutes = [];
        $zipAreaRange = [];
        $monthRange = [];
        /*foreach ($dates as $dateItem) {
            $monthRange[date('m-Y', strtotime($dateItem->getStart()))] = date('m/Y', strtotime($dateItem->getStart()));
        }*/
        foreach ($fleaMarkets as $fleaMarket) {
            $fleaMarketsDetailRoutes[$fleaMarket->getId()] = $this->app->getContainer()->router->pathFor('event-date', [
                'wildcard' => $fleaMarket->getSlug(),
                'id' => $fleaMarket->getId()
            ]);

            $zipArea = (int) substr($fleaMarket->getZipCode(), 0, 1);
            $zipAreaRange[$zipArea] = $zipArea;

            foreach ($fleaMarket->getDates() as $dateItem) {
                $monthRange[date('m-Y', strtotime($dateItem->getStart()))] = date('m/Y', strtotime($dateItem->getStart()));
            }
        }
        sort($zipAreaRange);

        $this->templateVariables['fleamarkets'] = $fleaMarkets;
        $this->templateVariables['fleamarketsDetailsRoutes'] = $fleaMarketsDetailRoutes;
        $this->templateVariables['wpCategories'] = $wpCategories;
        $this->templateVariables['monthRange'] = $monthRange;
        $this->templateVariables['zipAreaRange'] = $zipAreaRange;
        $this->templateVariables['isLoggedIn'] = $this->userService->isLoggedIn();
        $this->templateVariables['isTest'] = (boolean)$isTest;
        return array();
    }

}
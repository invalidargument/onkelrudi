<?php

namespace RudiBieller\OnkelRudi\Controller;

class IndexAction extends AbstractHttpAction
{
    const DEFAULT_ZIP_AREA = 'PLZ-Bereich';

    protected $template = 'index.html';

    protected function getData()
    {
        $start = null;
        $monthArgument = $this->_getArgValue('month');

        if (!is_null($monthArgument)) {
            list($month, $year) = explode('-', $monthArgument);
            $start = new \DateTimeImmutable($year . '-' . $month . '-01 00:00:01');
        }

        $zipArgument = $this->_getArgValue('zip');

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
        $this->templateVariables['selectedMonth'] = str_replace('-', '/', $monthArgument);
        $this->templateVariables['selectedZipAreaRange'] = $this->_getSelectedZipRange($zipArgument);
        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('profile');
        $this->templateVariables['createfleamarketurl'] = $this->app->getContainer()->get('router')->pathFor('create-fleamarket');
        $this->templateVariables['isLoggedIn'] = $this->userService->isLoggedIn();
        $this->templateVariables['isTest'] = (boolean)$isTest;

        return array();
    }

    private function _getSelectedZipRange($zip)
    {
        if (is_null($zip) || $zip == self::DEFAULT_ZIP_AREA) {
            return self::DEFAULT_ZIP_AREA;
        }

        return substr($zip, 0, 1);
    }

    private function _getArgValue($name)
    {
        if (array_key_exists($name, $this->args)) {
            return $this->args[$name];
        }

        return null;
    }
}

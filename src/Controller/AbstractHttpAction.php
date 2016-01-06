<?php

namespace RudiBieller\OnkelRudi\Controller;

abstract class AbstractHttpAction extends AbstractAction
{
    protected $template = 'index.html';

    protected function writeErrorResponse()
    {
        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                'error.html',
                array('error' => $this->getResponseErrorStatusMessage())
            );
    }

    protected function writeSuccessResponse()
    {
        // $this->result // type array key=>value
        /**
        [
        'fleamarkets' => $fleaMarkets,
        'fleamarketsDetailsRoutes' => $fleaMarketsDetailRoutes,
        'wpCategories' => $wpCategories
        ]
         */
        return $this->app->getContainer()->get('view')
            ->render($this->response, $this->template, ['data' => $this->result]);
    }
}

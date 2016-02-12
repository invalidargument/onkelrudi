<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Wordpress\ServiceInterface;

abstract class AbstractHttpAction extends AbstractAction implements HttpActionInterface
{
    protected $template = 'index.html';
    protected $wordpressService;

    public function setWordpressService(ServiceInterface $service)
    {
        $this->wordpressService = $service;
    }

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
        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                $this->template,
                ['data' => $this->result, 'wpCategories' => $this->wordpressService->getAllCategories()]
            );
    }
}

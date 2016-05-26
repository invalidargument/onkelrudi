<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Wordpress\ServiceInterface;

abstract class AbstractHttpAction extends AbstractAction implements HttpActionInterface
{
    protected $template = 'index.html';
    protected $templateVariables = array();
    /**
     * @var ServiceInterface
     */
    protected $wordpressService;

    public function setWordpressService(ServiceInterface $service)
    {
        $this->wordpressService = $service;
        return $this;
    }

    protected function writeErrorResponse()
    {
        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                'error.html',
                array(
                    'error' => $this->getResponseErrorStatusMessage(),
                    'wpCategories' => $this->wordpressService->getAllCategories()
                )
            );
    }

    protected function writeSuccessResponse()
    {
        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                $this->template,
                array_merge(
                    ['data' => $this->result, 'wpCategories' => $this->wordpressService->getAllCategories()],
                    $this->templateVariables
                )
            );
    }

    protected function writeAuthenticationRequiredResponse()
    {
        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                'unauthorized.html',
                array(
                    'error' => 'Für diese Aktion musst Du Dich anmelden.',
                    'returnurl' => (string) $this->request->getUri(),
                    'wpCategories' => $this->wordpressService->getAllCategories()
                )
            );
    }
}

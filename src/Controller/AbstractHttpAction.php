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
        $this->_setStandardTemplateVariables();

        $this->app->getContainer()->get('Logger')->critical('General error occured calling URI: ' . $this->request->getUri());

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
        $this->_setStandardTemplateVariables();

        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                $this->template,
                array_merge(
                    [
                        'data' => $this->result,
                        'wpCategories' => $this->wordpressService->getAllCategories(),
                        'isLoggedIn' => $this->userService->isLoggedIn()
                    ],
                    $this->templateVariables
                )
            );
    }

    protected function writeAuthenticationRequiredResponse()
    {
        $this->_setStandardTemplateVariables();

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

    private function _setStandardTemplateVariables()
    {
        $this->templateVariables['profileurl'] = $this->app->getContainer()->get('router')->pathFor('profile');
        $this->templateVariables['createfleamarketurl'] = $this->app->getContainer()->get('router')->pathFor('create-fleamarket');
        $this->templateVariables['changepasswordurl'] = $this->app->getContainer()->get('router')->pathFor('password');
        $this->templateVariables['logouturl'] = $this->app->getContainer()->get('router')->pathFor('logout');
    }
}

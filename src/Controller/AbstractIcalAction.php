<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Ical\ServiceInterface;

abstract class AbstractIcalAction extends AbstractAction implements IcalActionInterface
{
    /**
     * @var \RudiBieller\OnkelRudi\Ical\ServiceInterface
     */
    protected $icalService;

    public function setIcalService(ServiceInterface $service)
    {
        $this->icalService = $service;
    }

    protected function writeErrorResponse()
    {
        $this->app->getContainer()->get('Logger')->critical('General error occured calling URI: ' . $this->request->getUri());

        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                'error.html',
                array(
                    'error' => $this->getResponseErrorStatusMessage(),
                    'wpCategories' => []
                )
            );
    }

    protected function writeSuccessResponse()
    {
        return $this->app->getContainer()->get('response')
            ->withHeader(
                'Content-Type',
                'text/calendar; charset=utf-8'
            )
            ->withHeader(
                'Content-Disposition',
                'attachment; filename="cal.ics"'
            )
            ->write($this->result);
    }



    protected function writeAuthenticationRequiredResponse()
    {
        return $this->app->getContainer()->get('view')
            ->render(
                $this->response,
                'error.html',
                array(
                    'error' => $this->getResponseErrorStatusMessage(),
                    'wpCategories' => []
                )
            );
    }
}

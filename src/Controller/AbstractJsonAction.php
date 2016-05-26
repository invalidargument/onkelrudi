<?php

namespace RudiBieller\OnkelRudi\Controller;

abstract class AbstractJsonAction extends AbstractAction
{
    protected function writeErrorResponse()
    {
        return $this->app->getContainer()->get('response')
            ->withHeader(
                'Content-Type',
                'application/json'
            )
            ->withStatus($this->getResponseErrorStatusCode(), $this->getResponseErrorStatusMessage())
            ->write(json_encode(array('error' => $this->getResponseErrorStatusMessage())));
    }

    protected function writeSuccessResponse()
    {
        return $this->app->getContainer()->get('response')->withHeader(
            'Content-Type',
            'application/json'
        )->write(json_encode(array('data' => $this->result)));
    }



    protected function writeAuthenticationRequiredResponse()
    {
        return $this->app->getContainer()->get('response')
            ->withHeader(
                'Content-Type',
                'application/json'
            )
            ->withStatus(401, 'Authentication required')
            ->write(json_encode(array('error' => 'For this action an authentication is required.')));
    }
}

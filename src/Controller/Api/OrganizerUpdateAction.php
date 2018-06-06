<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\AbstractJsonAction;
use RudiBieller\OnkelRudi\Controller\UserAwareInterface;
use RudiBieller\OnkelRudi\FleaMarket\Builder;

class OrganizerUpdateAction extends AbstractJsonAction implements UserAwareInterface
{
    private $_dsgvoNotAcceptedMessage = 'Datenschutzhinweis not accepted!';
    private $_dsgvoNotAcceptedMessageStatusCode = 400;

    protected function getData()
    {
        /**
         * @var Builder
         */
        $builder = $this->builderFactory->create('RudiBieller\OnkelRudi\FleaMarket\OrganizerBuilder');
        $builder->reset();

        $organizerId = $this->args['id'];

        // if not found, return 404

        $builder->setId($organizerId);

        $data = $this->request->getParsedBody();

        if (!$this->_dsgvoAccepted($data)) {
            return null;
        }

        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($builder, $method)) {
                $builder->$method($value);
            }
        }

        return $this->organizerService->updateOrganizer($builder->build());
    }

    private function _dsgvoAccepted($requestVars)
    {
        return (boolean) $requestVars['acceptDataProcessing'];
    }

    protected function getResponseErrorStatusCode()
    {
        return $this->_dsgvoNotAcceptedMessageStatusCode;
    }

    protected function getResponseErrorStatusMessage()
    {
        return $this->_dsgvoNotAcceptedMessage;
    }
}

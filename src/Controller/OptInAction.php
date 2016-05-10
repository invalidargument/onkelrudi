<?php

namespace RudiBieller\OnkelRudi\Controller;

class OptInAction extends AbstractHttpAction
{
    protected $template = 'optIn.html';

    protected function getData()
    {
        $token = $this->args['token'];

        $success = $this->userService->optIn($token);

        if (!$success) {
            $this->templateVariables['fail'] = true;
        }

        return array();
    }
}

<?php

namespace RudiBieller\OnkelRudi\Controller;

class UserLoginAction extends AbstractJsonAction
{
    const DEFAULT_ERROR_RESPONSE_HTTP_STATUS_CODE = 403;
    const DEFAULT_ERROR_RESPONSE_MESSAGE = 'Login credentials not valid';

    protected function getData()
    {
        $data = $this->request->getParsedBody();

        if (!$this->userService->login($data['email'], $data['password'])) {
            return null;
        }

        return true;
    }
}
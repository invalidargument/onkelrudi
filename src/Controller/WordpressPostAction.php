<?php

namespace RudiBieller\OnkelRudi\Controller;

class WordpressPostAction extends AbstractHttpAction
{
    protected $template = 'wordpressPostDetail.html';

    protected function getData()
    {
        return $this->wordpressService->getPost($this->args['id']);
    }
}

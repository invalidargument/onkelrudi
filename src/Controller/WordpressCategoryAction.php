<?php

namespace RudiBieller\OnkelRudi\Controller;

use RudiBieller\OnkelRudi\Wordpress\Category;

class WordpressCategoryAction extends AbstractHttpAction
{
    protected $template = 'wordpressCategoryOverview.html';

    protected function getData()
    {
        $category = new Category();
        $category->setId($this->args['id']);

        $this->templateVariables = ['selectedCategory' => $this->args['id']];

        return $this->wordpressService->getPosts($category);
    }
}

<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use Slim\Container;

class QueryFactory implements QueryFactoryInterface
{
    private $_categoriesReadQuery;
    private $_postsReadQuery;
    private $_postReadQuery;

    private $_diContainer;

    public function setDiContainer(Container $diContainer)
    {
        $this->_diContainer = $diContainer;
    }

    public function createCategoryReadListQuery()
    {
        if (is_null($this->_categoriesReadQuery)) {
            $this->_categoriesReadQuery = new CategoryReadListQuery();
            $this->_categoriesReadQuery->setDiContainer($this->_diContainer);
        }

        return $this->_categoriesReadQuery;
    }

    public function createPostReadListQuery()
    {
        if (is_null($this->_postsReadQuery)) {
            $this->_postsReadQuery = new PostReadListQuery();
            $this->_postsReadQuery->setDiContainer($this->_diContainer);
        }

        return $this->_postsReadQuery;
    }

    public function createPostReadQuery()
    {
        if (is_null($this->_postReadQuery)) {
            $this->_postReadQuery = new PostReadQuery();
            $this->_postReadQuery->setDiContainer($this->_diContainer);
        }

        return $this->_postReadQuery;
    }
}

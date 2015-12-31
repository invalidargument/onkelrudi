<?php

namespace RudiBieller\OnkelRudi\Wordpress;

class QueryFactory implements QueryFactoryInterface
{
    private $_categoriesReadQuery;
    private $_postsReadQuery;

    function createCategoryReadListQuery()
    {
        if (is_null($this->_categoriesReadQuery)) {
            $this->_categoriesReadQuery = new CategoryReadListQuery();
        }

        return $this->_categoriesReadQuery;
    }

    function createPostReadListQuery()
    {
        if (is_null($this->_postsReadQuery)) {
            $this->_postsReadQuery = new PostReadListQuery();
        }

        return $this->_postsReadQuery;
    }
}
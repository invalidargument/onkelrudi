<?php

namespace RudiBieller\OnkelRudi\Wordpress;

class Service implements ServiceInterface
{
    /**
     * @var QueryFactory
     */
    private $_factory;

    public function setQueryFactory(QueryFactoryInterface $factory)
    {
        $this->_factory = $factory;
    }

    public function getAllCategories()
    {
        return $this->_factory->createCategoryReadListQuery()->run();
    }

    public function getPosts(Category $category, $offset = 0, $limit = 10)
    {
        return $this->_factory->createPostReadListQuery()
            ->setOffset($offset)
            ->setLimit($limit)
            ->run();
    }

    public function getPost($identifier)
    {
        return $this->_factory->createPostReadQuery()
            ->setId($identifier)
            ->run();
    }
}

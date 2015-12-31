<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Query\AbstractJsonReadQuery;

class CategoryReadListQuery extends AbstractJsonReadQuery
{
    protected $uri = 'http://localhost/wordpress/wp-json/wp/v2/categories';

    protected function mapResult($result)
    {
        $categories = json_decode($result);

        if (count($categories) === 0) {
            return array();
        }

        $mappedCategories = array();

        foreach ($categories as $cat) {
            $item = new Category();
            $item->setId($cat->id)
                ->setCount($cat->count)
                ->setParent($cat->parent)
                ->setName($cat->name);

            $mappedCategories[] = $item;
        }

        return $mappedCategories;
    }
}
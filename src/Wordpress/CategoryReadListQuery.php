<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\Query\AbstractJsonReadQuery;

class CategoryReadListQuery extends AbstractJsonReadQuery
{
    protected function getUri()
    {
        $config = new Config();
        $wpConfig = $config->getWordpressConfiguration();
        $systemConfig = $config->getSystemConfiguration();
        
        return $systemConfig['protocol'] . $wpConfig['api-domain'] .
            $wpConfig['api-base-url'] . $wpConfig['api-get-categories'];
    }

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
                ->setName($cat->name)
                ->setSlug($cat->slug);

            $mappedCategories[] = $item;
        }

        return $mappedCategories;
    }
}

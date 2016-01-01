<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\Query\AbstractJsonReadQuery;

class PostReadListQuery extends AbstractJsonReadQuery
{
    protected function getUri()
    {
        return Config::$system['protocol'] . Config::$wordpress['api-domain'] .
            Config::$wordpress['api-base-url'] . Config::$wordpress['api-get-posts'];
    }

    protected function mapResult($result)
    {
        $posts = json_decode($result);

        if (count($posts) === 0) {
            return array();
        }

        $mappedPosts = array();

        foreach ($posts as $post) {
            $item = new Post();
            $item->setId($post->id)
                ->setDate($post->date) //gmt???
                ->setDateModified($post->modified) //gmt???
                ->setTitle($post->title->rendered)
                ->setExcerpt($post->excerpt->rendered)
                ->setContent($post->content->rendered);

            $mappedPosts[] = $item;
        }

        return $mappedPosts;
    }
}
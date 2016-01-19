<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;
use RudiBieller\OnkelRudi\Query\AbstractJsonReadQuery;

class PostReadListQuery extends AbstractJsonReadQuery
{
    private $_limit;
    private $_offset;

    protected function getUri()
    {
        $config = new Config();
        $wpConfig = $config->getWordpressConfiguration();
        $systemConfig = $config->getSystemConfiguration();
        
        return $systemConfig['protocol'] . $wpConfig['api-domain'] .
            $wpConfig['api-base-url'] . $wpConfig['api-get-posts'];
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->_offset;
    }

    /**
     * @param int $offset
     * @return PostReadListQuery
     */
    public function setOffset($offset)
    {
        $this->_offset = $offset;
        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->_limit;
    }

    /**
     * @param int $limit
     * @return PostReadListQuery
     */
    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
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
                ->setContent($post->content->rendered)
                ->setSlug($post->slug);

            $mappedPosts[] = $item;
        }

        return $mappedPosts;
    }
}

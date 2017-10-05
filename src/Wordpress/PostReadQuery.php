<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\CacheableInterface;
use RudiBieller\OnkelRudi\Query\AbstractJsonReadQuery;

class PostReadQuery extends AbstractJsonReadQuery implements CacheableInterface
{
    private $_id;

    protected function getUri()
    {
        $wpConfig = $this->diContainer->get('config')->getWordpressConfiguration();
        $systemConfig = $this->diContainer->get('config')->getSystemConfiguration();

        return $systemConfig['protocol'] . $wpConfig['api-domain'] .
        $wpConfig['api-base-url'] . $wpConfig['api-get-post'] . $this->getId();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     * @return PostReadQuery
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    protected function mapResult($result)
    {
        $post = json_decode($result);

        if (count($post) === 0) {
            return array();
        }

        $item = new Post();
        $item->setPostId($post->id)
            ->setDate($post->date) //gmt???
            ->setDateModified($post->modified) //gmt???
            ->setTitle($post->title->rendered)
            ->setExcerpt($post->excerpt->rendered)
            ->setContent(
                $this->_cleanUpWordpressImageSourcePaths($post->content->rendered)
            )
            ->setSlug($post->slug);

        return $item;
    }

    protected function getTtl()
    {
        return self::TTL * 12;
    }

    private function _cleanUpWordpressImageSourcePaths($content)
    {
        switch ($this->diContainer->config->getSystemConfiguration()['environment']) {
            case 'live':
                return str_replace(
                    'http://' . $this->diContainer->config->getWordpressConfiguration()['api-domain'] . '/../onkelrudi/current/public/',
                    '',
                    $content
                );
                break;

            default:
                return str_replace(
                    'http://localhost:8089/wordpress/..',
                    '',
                    $content
                );
                break;
        }
    }
}

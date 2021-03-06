<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;
use Slim\Container;

class PostReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryReturnsMappedPosts()
    {
        $config = new Config('settings.yml.dist');
        $wpConfig = $config->getWordpressConfiguration();
        
        $post = new Post();
        $post
            ->setPostId(6)
            ->setDate('2015-11-29T21:24:49')
            ->setDateModified('2015-11-29T21:24:49')
            ->setContent("<p>bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla</p>\n")
            ->setExcerpt("<p>bla bla bla</p>\n")
            ->setTitle('Beitrag Nummer zwei')
            ->setSlug('beitrag-nummer-zwei');

        $postsJson = file_get_contents(dirname(__FILE__).'/data/posts.json');

        $browser = \Mockery::mock('Buzz\Browser');
        $browser->shouldReceive('get')->once()->with('http://localhost/wordpress/wp-json/wp/v2/posts', ['Content-Type: application/json'], '')->andReturn($browser)
            ->shouldReceive('getContent')->andReturn($postsJson)
            ->shouldReceive('addListener')->with(\Hamcrest\Matchers::equalTo(new \Buzz\Listener\BasicAuthListener($wpConfig['auth-username'], $wpConfig['auth-password'])));

        $cacheManager = \Mockery::mock('RudiBieller\OnkelRudi\Cache\CacheManager');
        $cacheManager->shouldReceive('get')->andReturn(null)
            ->shouldReceive('set');

        $sut = new PostReadListQuery();
        $sut->setBrowser($browser);
        $sut->setDiContainer(
            new Container([
                'config' => $config,
                'CacheManager' => $cacheManager
            ])
        );

        $result = $sut->run();
        $expected = array($post);

        $this->assertEquals($expected, $result);
    }
}

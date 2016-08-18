<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;
use Slim\Container;

class PostReadQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryReturnsMappedPosts()
    {
        $config = new Config('settings.yml.dist');
        $wpConfig = $config->getWordpressConfiguration();

        $post = new Post();
        $post
            ->setId(1)
            ->setDate('2015-11-28T23:26:09')
            ->setDateModified('2015-11-28T23:26:09')
            ->setContent("<p>Willkommen zur deutschen Version von WordPress. Dies ist der erste Beitrag. Du kannst ihn bearbeiten oder löschen. Und dann starte mit dem Schreiben!</p>\n")
            ->setExcerpt("<p>Willkommen zur deutschen Version von WordPress. Dies ist der erste Beitrag. Du kannst ihn bearbeiten oder löschen. Und dann starte mit dem Schreiben!</p>\n")
            ->setTitle('Hallo Welt!')
            ->setSlug('hallo-welt');

        $postsJson = file_get_contents(dirname(__FILE__).'/data/post.json');

        $browser = \Mockery::mock('Buzz\Browser');
        $browser->shouldReceive('get')->once()->with('http://localhost/wordpress/wp-json/wp/v2/posts/1', ['Content-Type: application/json'], '')->andReturn($browser)
            ->shouldReceive('getContent')->andReturn($postsJson)
            ->shouldReceive('addListener')->with(\Hamcrest\Matchers::equalTo(new \Buzz\Listener\BasicAuthListener($wpConfig['auth-username'], $wpConfig['auth-password'])));

        $cacheManager = \Mockery::mock('RudiBieller\OnkelRudi\Cache\CacheManager');
        $cacheManager->shouldReceive('get')->andReturn(null)
            ->shouldReceive('set');

        $sut = new PostReadQuery();
        $sut->setBrowser($browser);
        $sut->setDiContainer(
            new Container([
                'config' => $config,
                'CacheManager' => $cacheManager
            ])
        );
        $sut->setId(1);

        $result = $sut->run();
        $expected = $post;

        $this->assertEquals($expected, $result);
    }
}

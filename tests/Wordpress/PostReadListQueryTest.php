<?php

namespace RudiBieller\OnkelRudi\Wordpress;

use RudiBieller\OnkelRudi\Config\Config;

class PostReadListQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testQueryReturnsMappedPosts()
    {
        $post = new Post();
        $post
            ->setId(6)
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
            ->shouldReceive('addListener')->with(\Hamcrest\Matchers::equalTo(new \Buzz\Listener\BasicAuthListener(Config::$wordpress['auth-username'], Config::$wordpress['auth-password'])));

        $sut = new PostReadListQuery();
        $sut->setBrowser($browser);

        $result = $sut->run();
        $expected = array($post);

        $this->assertEquals($expected, $result);
    }
}

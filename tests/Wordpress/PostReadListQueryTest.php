<?php

namespace RudiBieller\OnkelRudi\Wordpress;

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
            ->setTitle('Beitrag Nummer zwei');

        $postsJson = file_get_contents(dirname(__FILE__).'/data/posts.json');

        $browser = \Mockery::mock('Buzz\Browser');
        $browser->shouldReceive('get')->andReturn($browser)
            ->shouldReceive('getContent')->andReturn($postsJson);

        $sut = new PostReadListQuery();
        $sut->setBrowser($browser);

        $result = $sut->run();
        $expected = array($post);

        $this->assertEquals($expected, $result);
    }
}

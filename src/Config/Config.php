<?php
namespace RudiBieller\OnkelRudi\Config;

class Config
{
    public static $database = [
        'dsn' => "mysql:host=127.0.0.1;dbname=onkelrudi;charset=utf8",
        'user' => "root",
        'password' => "root"
    ];

    public static $system = [
        'environment' => "dev",
        'domain' => "localhost",
        'protocol' => 'http://'
    ];

    public static $wordpress = [
        'api-documentation' => 'http://v2.wp-api.org/',
        'api-domain' => "localhost",
        'api-base-url' => '/wordpress/wp-json/wp/v2/',
        'api-get-posts' => 'posts',
        'api-get-categories' => 'categories'
    ];
}

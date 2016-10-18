<?php

namespace RudiBieller\OnkelRudi\Handler;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeCallsLogger()
    {
        $logger = \Mockery::mock('Monolog\Logger');
        $logger->shouldReceive('critical')->once()->with(\Hamcrest\Matchers::startsWith('foobarbaz'));

        $result = new Error($logger);

        $request = \Mockery::mock('Psr\Http\Message\ServerRequestInterface');
        $request->shouldReceive('getHeaderLine');
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('withStatus')->andReturn($response);
        $response->shouldReceive('withHeader')->andReturn($response);
        $response->shouldReceive('withBody')->andReturn($response);
        $exception = new \Exception('foobarbaz');

        $result($request, $response, $exception);
    }
}

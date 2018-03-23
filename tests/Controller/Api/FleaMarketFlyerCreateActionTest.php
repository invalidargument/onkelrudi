<?php

namespace RudiBieller\OnkelRudi\Controller\Api;

use RudiBieller\OnkelRudi\Controller\Fixture\Factory;
use RudiBieller\OnkelRudi\User\User;

class FleaMarketFlyerCreateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testUploadOfImageFileReturnsFalseIfNoFileWasUploaded()
    {
        $userService = Factory::createUserServiceWithAuthenticatedUserSession(new User('a@a.de'));

        $app = Factory::createSlimAppWithStandardTestContainer();

        $request = Factory::createTestRequest();
        $request->shouldReceive('getUploadedFiles')->once()->andReturn(array());
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new FleaMarketFlyerCreateAction();
        $action->setApp($app)
            ->setUserService($userService);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => false));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    public function testUploadOfImageFileReturnsErrorWhenUploadedFilesAreErroreous()
    {
        $userService = Factory::createUserServiceWithAuthenticatedUserSession(new User('a@a.de'));

        $flyer = \Mockery::mock('Psr\Http\Message\UploadedFileInterface');
        $flyer->shouldReceive('getError')->andReturn(UPLOAD_ERR_CANT_WRITE);
        $uploadedFiles = array(
            'flyer' => $flyer
        );

        $app = Factory::createSlimAppWithStandardTestContainer();

        $request = Factory::createTestRequest();
        $request->shouldReceive('getUploadedFiles')->once()->andReturn($uploadedFiles);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new FleaMarketFlyerCreateAction();
        $action->setApp($app)
            ->setUserService($userService);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('error' => 'Error uploading file, UPLOAD_ERR_*: 7'));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
        $this->assertSame(400, $return->getStatusCode());
    }

    public function testUploadOfImageFile()
    {
        $userService = Factory::createUserServiceWithAuthenticatedUserSession(new User('a@a.de'));

        $flyer = \Mockery::mock('Psr\Http\Message\UploadedFileInterface');
        $flyer->shouldReceive('getError')->andReturn(UPLOAD_ERR_OK)
            ->shouldReceive('getClientFilename')->andReturn('image.jpg')
            ->shouldReceive('moveTo')->once()->with('/path/to/upload/a@a.de/image.jpg');
        $uploadedFiles = array(
            'flyer' => $flyer
        );

        $app = Factory::createSlimAppWithStandardTestContainer();
        $app->getContainer()->get('Filesystem')
            ->shouldReceive('exists')->once()->with('/path/to/upload/a@a.de/')
            ->shouldReceive('makeDirectory')->once()->with('/path/to/upload/a@a.de/', 0777, true);

        $request = Factory::createTestRequest();
        $request->shouldReceive('getUploadedFiles')->once()->andReturn($uploadedFiles);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new FleaMarketFlyerCreateAction();
        $action->setApp($app)
            ->setUserService($userService);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('data' => 1));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    /**
     * @dataProvider dataProviderTestUploadOfImageFileReturnsErrorOnReceivingAnException
     */
    public function testUploadOfImageFileReturnsErrorOnReceivingAnException($exception)
    {
        $userService = Factory::createUserServiceWithAuthenticatedUserSession(new User('a@a.de'));

        $flyer = \Mockery::mock('Psr\Http\Message\UploadedFileInterface');
        $flyer->shouldReceive('getError')->andReturn(UPLOAD_ERR_OK)
            ->shouldReceive('getClientFilename')->andReturn('image.jpg')
            ->shouldReceive('moveTo')->once()->andThrow($exception);
        $uploadedFiles = array(
            'flyer' => $flyer
        );

        $app = Factory::createSlimAppWithStandardTestContainer();
        $app->getContainer()->get('Filesystem')
            ->shouldReceive('exists')->once()->with('/path/to/upload/a@a.de/')
            ->shouldReceive('makeDirectory')->once()->with('/path/to/upload/a@a.de/', 0777, true);

        $request = Factory::createTestRequest();
        $request->shouldReceive('getUploadedFiles')->once()->andReturn($uploadedFiles);
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');

        $action = new FleaMarketFlyerCreateAction();
        $action->setApp($app)
            ->setUserService($userService);

        $return = $action($request, $response, array());
        $actual = (string)$return->getBody();
        $expected = json_encode(array('error' => 'test'));

        $this->assertJsonStringEqualsJsonString($expected, $actual);
        $this->assertSame(400, $return->getStatusCode());
    }

    public function dataProviderTestUploadOfImageFileReturnsErrorOnReceivingAnException()
    {
        return array(
            array(new \InvalidArgumentException('test')),
            array(new \RuntimeException('test'))
        );
    }
}

<?php

namespace RudiBieller\OnkelRudi\User;

class DbAuthenticationAdapterTest extends \PHPUnit_Framework_TestCase
{
    private $_sut;
    private $_pdo;

    protected function setUp()
    {
        $this->_sut = new DbAuthenticationAdapter();
        $this->_pdo = \Mockery::mock('\Slim\PDO\Database');
        $this->_sut->setPdo($this->_pdo);
    }

    /**
     * @dataProvider dataProviderTestAdapterVerifiesCredentialsByQueryingDatabase
     */
    public function testAdapterVerifiesCredentialsByQueryingDatabase($identifier, $password, $hash, $expectedResult, $expectedCode)
    {
        $this->_sut->setIdentifier($identifier)->setPassword($password);

        $statement = \Mockery::mock('\PDOStatement');
        $statement->shouldReceive('fetch')
            ->once()
            ->andReturn($hash);

        $this->_pdo
            ->shouldReceive('select')
                ->with(['password'])
                ->andReturn($this->_pdo)
            ->shouldReceive('from')
                ->with('fleamarkets_users')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('email', '=', 'foo@bar.de')
                ->andReturn($this->_pdo)
            ->shouldReceive('where')
                ->once()
                ->with('opt_in', '=', '1')
                ->andReturn($this->_pdo)
            ->shouldReceive('execute')
                ->once()
                ->andReturn($statement);

        $result = $this->_sut->authenticate();

        $this->assertInstanceOf('Zend\Authentication\Result', $result);
        $this->assertSame($expectedResult, $result->isValid());
        $this->assertSame($expectedCode, $result->getCode());
    }

    public function dataProviderTestAdapterVerifiesCredentialsByQueryingDatabase()
    {
        return array(
            array('foo@bar.de', '123', password_hash('123', PASSWORD_DEFAULT), true, 1),
            array('foo@bar.de', '123', password_hash('666', PASSWORD_DEFAULT), false, -3),
            array('foo@bar.de', '123', null, false, -1)
        );
    }
}

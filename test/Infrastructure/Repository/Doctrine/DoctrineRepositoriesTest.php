<?php

namespace Restest\Infrastructure\Repository\Doctrine;

class DoctrineRepositoriesTest extends \PHPUnit\Framework\TestCase
{
    private $configuration;
    private $doctrineRepositories;

    public function setUp()
    {
        $this->configuration = [
            "driver" => 'pdo_mysql',
            "host" => 'localhost',
            "port" => '3306',
            "user" => 'root',
            "password" => 'cambridge129',
            "dbname" => 'restestapi_test',
            "charset" => 'utf8'
        ];
        $this->doctrineRepositories = new DoctrineRepositories($this->configuration);
    }

    public function testForContract()
    {
        $this->assertInstanceOf(DoctrineRepositoryContract::class, $this->doctrineRepositories->forContract());
    }

    public function testForUser()
    {
        $this->assertInstanceOf(DoctrineRepositoryUser::class, $this->doctrineRepositories->forUser());
    }

    public function testForRole()
    {
        $this->assertInstanceOf(DoctrineRepositoryRole::class, $this->doctrineRepositories->forRole());
    }

    public function testGetEntityManager()
    {
        $this->assertEquals(
            $this->doctrineRepositories->createEntityManager($this->configuration),
            $this->doctrineRepositories->getEntityManager()
        );
    }
}
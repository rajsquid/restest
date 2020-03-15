<?php

namespace Restest\Application;

use Restest\Application\Presentation\JsonPresentations;
use Restest\Domain\Helper\HelperObject;
use Restest\Domain\Presentation\Presentations;
use Restest\Domain\Repository\Repositories;
use Restest\Infrastructure\Configuration;

abstract class ApplicationTestCase extends \PHPUnit\Framework\TestCase
{
    protected $repository;
    protected $client;
    protected $app;

    public function setUp()
    {
        parent::setUp();
        $this->app = $this->getSlimInstance();

        $this->app->getContainer()['logger'] = function ($c) {
            return $this->getMockBuilder(\Monolog\Logger::class)->disableOriginalConstructor()->getMock();
        };

        $configuration = parse_ini_file(__DIR__ . '/../../config/application.test.ini', true);
        Configuration::init($configuration);
        $this->client = new WebTestClient($this->app);
        $this->repository = $this->getMockBuilder(Repositories::class)->getMock();
        Repositories::initialize($this->repository);
        Presentations::initialize(new JsonPresentations());
    }

    public function getSlimInstance()
    {
        $app = new \Slim\App();

        include __DIR__ . '/../../src/middleware.php';
        include __DIR__ . '/../../src/routes.php';
        return $app;
    }

    protected function returnArgumentWithId()
    {
        return $this->returnCallback(function ($object) {
            return HelperObject::editPrivateProperty('id', 1, $object);
        });
    }

    protected function assertStatusEquals($code)
    {
        $this->assertEquals($code, $this->client->response->getStatusCode());
    }

    protected function assertResultEquals($expected)
    {
        $body = $this->client->response->getBody();
        $this->assertEquals($expected, json_decode($body, true));
        return $body;
    }

    protected function createDomainMock($entity)
    {
        return $this->getMockBuilder("App\Domain\\$entity")->disableOriginalConstructor()->getMock();
    }

    protected function createRepositoryMock($className)
    {
        $entrepot = $this->getMockBuilder("App\Domain\Repository\\${className}Repository")->getMock();
        $this->repository->expects($this->any())->method('for' . $className)->willReturn($entrepot);
        return $entrepot;
    }
}
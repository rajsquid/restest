<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Doctrine\Common\Persistence\Mapping\Driver\PHPDriver;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Restest\Domain\Repository\Repositories;

class DoctrineRepositories extends Repositories
{
    protected $entityManager;

    public function __construct($configurationConnexion)
    {
        $this->entityManager = $this->createEntityManager($configurationConnexion);
    }

    public static function createEntityManager($configurationConnexion)
    {
        $configuration = new Configuration();
        $configuration->setMetadataCacheImpl(new \Doctrine\Common\Cache\ApcuCache());
        $configuration->setQueryCacheImpl(new \Doctrine\Common\Cache\ApcuCache());
        $configuration->setResultCacheImpl(new \Doctrine\Common\Cache\ApcuCache());

        $cacheConfig = new \Doctrine\ORM\Cache\CacheConfiguration();
        $factory = new \Doctrine\ORM\Cache\DefaultCacheFactory($cacheConfig->getRegionsConfiguration(), new \Doctrine\Common\Cache\ApcuCache());
        $configuration->setSecondLevelCacheEnabled();
        $configuration->getSecondLevelCacheConfiguration()->setCacheFactory($factory);

        $configuration->setAutoGenerateProxyClasses(true);
        $configuration->setMetadataDriverImpl(new PHPDriver(__DIR__ . "/Mapping"));
        $configuration->setProxyDir(__DIR__ . "/../../../../generated/Restest/Infrastructure/Repository/Doctrine/Proxy");
        $configuration->setProxyNamespace("Restest\Infrastructure\Repository\Doctrine\Proxy");
        return EntityManager::create($configurationConnexion, $configuration);
    }

    public function forUser()
    {
        return new DoctrineRepositoryUser($this->entityManager);
    }

    public function forContract()
    {
        return new DoctrineRepositoryContract($this->entityManager);
    }

    public function forRole()
    {
        return new DoctrineRepositoryRole($this->entityManager);
    }

    public function forRisk()
    {
        return new DoctrineRepositoryRisk($this->entityManager);
    }

    public function forProcess()
    {
        return new DoctrineRepositoryProcess($this->entityManager);
    }

    public function forReview()
    {
        return new DoctrineRepositoryReview($this->entityManager);
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    public function rollback()
    {
        $this->entityManager->rollback();
    }

    public function commit()
    {
        $this->entityManager->flush();
        $this->entityManager->commit();
    }
}
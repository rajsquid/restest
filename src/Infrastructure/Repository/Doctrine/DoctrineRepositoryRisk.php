<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Repository\IRepositoryRisk;
use Restest\Domain\Risk;


class DoctrineRepositoryRisk extends SimpleDoctrineRepository implements IRepositoryRisk
{
    protected static $entity = Risk::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get risk with empty name.");
        return $this->entityManager
            ->getRepository(Risk::class)
            ->findBy(['name' => $name]);
    }
}
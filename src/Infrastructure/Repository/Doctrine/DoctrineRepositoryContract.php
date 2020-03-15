<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Repository\IRepositoryContract;
use Restest\Domain\Contract;

class DoctrineRepositoryContract extends SimpleDoctrineRepository implements IRepositoryContract
{
    protected static $entity = Contract::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get contract with empty name.");
        return $this->entityManager
            ->getRepository(Contract::class)
            ->findBy(['name' => $name]);
    }
}

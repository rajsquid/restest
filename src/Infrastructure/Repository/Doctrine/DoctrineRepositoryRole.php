<?php


namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Repository\IRepositoryContract;
use Restest\Domain\Repository\IRepositoryRole;
use Restest\Domain\Role;


class DoctrineRepositoryRole extends SimpleDoctrineRepository implements IRepositoryRole
{
    protected static $entity = Role::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get role with empty name.");
        return $this->entityManager
            ->getRepository(Role::class)
            ->findBy(['name' => $name]);
    }
}
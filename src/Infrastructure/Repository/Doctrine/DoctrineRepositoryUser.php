<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Repository\IRepositoryUser;
use Restest\Domain\User;

class DoctrineRepositoryUser extends SimpleDoctrineRepository implements IRepositoryUser
{
    protected static $entity = User::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get user with empty name.");
        return $this->entityManager
            ->getRepository(User::class)
            ->findBy(['name' => $name]);
    }
}

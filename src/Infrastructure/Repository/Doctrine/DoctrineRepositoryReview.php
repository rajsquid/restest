<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Repository\IRepositoryReview;
use Restest\Domain\Review;

class DoctrineRepositoryReview extends SimpleDoctrineRepository implements IRepositoryReview
{
    protected static $entity = Review::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get review with empty name.");
        return $this->entityManager
            ->getRepository(Review::class)
            ->findBy(['name' => $name]);
    }
}

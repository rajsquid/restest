<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Helper\HelperParameter;
use Restest\Domain\Repository\IRepositoryProcess;
use Restest\Domain\Process;

class DoctrineRepositoryProcess extends SimpleDoctrineRepository implements IRepositoryProcess
{
    protected static $entity = Process::class;

    public function getByName($name)
    {
        HelperParameter::checkNotEmpty($name, "Impossible to get user with empty name.");
        return $this->entityManager
            ->getRepository(Process::class)
            ->findBy(['name' => $name]);
    }

    public function insert($data) {
        $sql = "INSERT INTO user_process_assignment (user_id, contract_id) VALUES (:user_id, :contract_id)";
        $connection = $this->entityManager->getConnection();
        $connection->prepare($sql)->execute($data);
        return $connection->lastInsertId();
    }


    public function getAll() {
        $sql = "SELECT * FROM user_process_assignment";
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get($data) {
        $sql = "SELECT * FROM user_process_assignment where id=".$data;
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
}
